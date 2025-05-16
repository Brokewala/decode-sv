<?php

namespace App\Http\Controllers;

use App\Models\Document;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('admin');
    }

    /**
     * Display a dashboard with admin statistics.
     */
    public function dashboard()
    {
        $totalUsers = User::count();
        $totalDocuments = Document::count();
        $pendingDocuments = Document::where('is_verified', false)->count();
        $totalDownloads = Document::sum('downloads');

        return view('admin.dashboard', compact('totalUsers', 'totalDocuments', 'pendingDocuments', 'totalDownloads'));
    }

    /**
     * Display a list of documents pending moderation.
     */
    public function pendingDocuments(Request $request)
    {
        $query = Document::where('is_verified', false)
                        ->with('user');

        // Filtrer par recherche
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('country', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        // Filtrer par pays
        if ($request->filled('country')) {
            $query->where('country', $request->input('country'));
        }

        // Filtrer par format
        if ($request->filled('format')) {
            $format = $request->input('format');
            if ($format === 'pdf') {
                $query->where('format', 'pdf');
            } elseif ($format === 'doc') {
                $query->whereIn('format', ['doc', 'docx']);
            } elseif ($format === 'xls') {
                $query->whereIn('format', ['xls', 'xlsx']);
            }
        }

        // Tri par date (default: plus anciens en premier)
        $sort = $request->input('sort', 'oldest');
        if ($sort === 'newest') {
            $query->orderBy('created_at', 'desc');
        } else {
            $query->orderBy('created_at', 'asc');
        }

        $documents = $query->paginate(10);

        return view('admin.pending', compact('documents'));
    }

    /**
     * Verify a document and award points to the uploader.
     */
    public function verifyDocument(Document $document)
    {
        // Vérifier si le document est déjà validé
        if ($document->is_verified) {
            return back()->with('info', 'Ce document a déjà été validé.');
        }

        // Valider le document
        $document->is_verified = true;
        $document->save();

        // Attribuer les points à l'utilisateur qui a déposé le document
        $user = $document->user;
        $pointsToAdd = $document->price;
        $user->points += $pointsToAdd;
        $user->save();

        return back()->with('success', "Le document a été validé avec succès et {$pointsToAdd} points ont été attribués à {$user->name}.");
    }

    /**
     * Reject and delete a document.
     */
    public function rejectDocument(Document $document)
    {
        // Supprimer les fichiers
        if (Storage::disk('private')->exists($document->file_path)) {
            Storage::disk('private')->delete($document->file_path);
        }
        
        if ($document->preview_path && Storage::disk('public')->exists($document->preview_path)) {
            Storage::disk('public')->delete($document->preview_path);
        }

        // Récupérer le nom de l'utilisateur avant suppression pour le message
        $userName = $document->user->name;

        // Supprimer le document
        $document->delete();

        return back()->with('success', "Le document a été rejeté et supprimé. L'utilisateur {$userName} a été notifié.");
    }

    /**
     * Display a list of users.
     */
    public function users(Request $request)
    {
        $query = User::query();

        // Filtrer par recherche
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        // Tri
        $sort = $request->input('sort', 'newest');
        switch ($sort) {
            case 'newest':
                $query->orderBy('created_at', 'desc');
                break;
            case 'oldest':
                $query->orderBy('created_at', 'asc');
                break;
            case 'name':
                $query->orderBy('name', 'asc');
                break;
            case 'points_desc':
                $query->orderBy('points', 'desc');
                break;
            case 'points_asc':
                $query->orderBy('points', 'asc');
                break;
        }

        $users = $query->paginate(15);

        return view('admin.users', compact('users'));
    }

    /**
     * Toggle admin status for a user.
     */
    public function toggleAdmin(User $user)
    {
        // Ne pas permettre à un admin de retirer ses propres droits
        if ($user->id === Auth::id()) {
            return back()->with('error', 'Vous ne pouvez pas modifier vos propres droits d\'administrateur.');
        }

        $user->is_admin = !$user->is_admin;
        $user->save();

        $status = $user->is_admin ? 'administrateur' : 'utilisateur standard';
        return back()->with('success', "{$user->name} est maintenant un {$status}.");
    }
}