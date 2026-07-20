<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TeamMember;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class TeamMemberController extends Controller
{
    /**
     * Display all team members.
     */
    public function index(Request $request): View
    {
        $search = trim((string) $request->input('search'));

        $teamMembers = TeamMember::query()
            ->with('user')
            ->when($search, function ($query) use ($search) {
                $query->where(function ($teamQuery) use ($search) {
                    $teamQuery
                        ->where('position', 'like', "%{$search}%")
                        ->orWhere('department', 'like', "%{$search}%")
                        ->orWhereHas('user', function ($userQuery) use ($search) {
                            $userQuery
                                ->where('first_name', 'like', "%{$search}%")
                                ->orWhere('last_name', 'like', "%{$search}%")
                                ->orWhere('email', 'like', "%{$search}%");
                        });
                });
            })
            ->orderBy('display_order')
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view('admin.team-members.index', compact('teamMembers'));
    }

    /**
     * Show the team-member creation form.
     */
    public function create(): View
    {
        return view('admin.team-members.create');
    }

    /**
     * Store a new user and team-member profile.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            // User information
            'first_name' => ['required', 'string', 'max:100'],
            'last_name'  => ['required', 'string', 'max:100'],
            'email'      => ['required', 'email', 'max:255', 'unique:users,email'],
            'phone'      => ['nullable', 'string', 'max:30'],
            'password'   => ['required', 'string', 'min:8', 'confirmed'],
            'status'     => [
                'required',
                Rule::in(['active', 'inactive', 'suspended']),
            ],

            // Team-member information
            'title'               => ['nullable', 'string', 'max:50'],
            'position'            => ['required', 'string', 'max:255'],
            'department'          => ['nullable', 'string', 'max:255'],
            'slug'                => ['nullable', 'string', 'max:255', 'unique:team_members,slug'],
            'image'               => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'short_bio'           => ['nullable', 'string', 'max:1000'],
            'bio'                 => ['nullable', 'string'],
            'qualification'       => ['nullable', 'string', 'max:255'],
            'specialization'      => ['nullable', 'string', 'max:255'],
            'years_of_experience' => ['nullable', 'integer', 'min:0', 'max:100'],

            // Links
            'website'   => ['nullable', 'url', 'max:255'],
            'facebook'  => ['nullable', 'url', 'max:255'],
            'twitter'   => ['nullable', 'url', 'max:255'],
            'instagram' => ['nullable', 'url', 'max:255'],
            'linkedin'  => ['nullable', 'url', 'max:255'],
            'youtube'   => ['nullable', 'url', 'max:255'],

            // Display controls
            'display_order' => ['nullable', 'integer', 'min:0'],
            'is_featured'   => ['nullable', 'boolean'],
            'is_active'     => ['nullable', 'boolean'],
            'published_at'  => ['nullable', 'date'],
        ]);

        DB::beginTransaction();

        try {
            $user = User::create([
                'first_name' => $validated['first_name'],
                'last_name'  => $validated['last_name'],
                'email'      => $validated['email'],
                'phone'      => $validated['phone'] ?? null,
                'password'   => Hash::make($validated['password']),
                'status'     => $validated['status'],
            ]);

            $imagePath = null;

            if ($request->hasFile('image')) {
                $imagePath = $request->file('image')
                    ->store('team-members', 'public');
            }

            $requestedSlug = $validated['slug'] ?? null;

            $slugSource = $requestedSlug ?: implode(' ', [
                $validated['first_name'],
                $validated['last_name'],
            ]);

            TeamMember::create([
                'user_id'             => $user->id,
                'slug'                => $this->generateUniqueSlug($slugSource),
                'title'               => $validated['title'] ?? null,
                'position'            => $validated['position'],
                'department'          => $validated['department'] ?? null,
                'image'               => $imagePath,
                'short_bio'           => $validated['short_bio'] ?? null,
                'bio'                 => $validated['bio'] ?? null,
                'qualification'       => $validated['qualification'] ?? null,
                'specialization'      => $validated['specialization'] ?? null,
                'years_of_experience' => $validated['years_of_experience'] ?? null,
                'website'             => $validated['website'] ?? null,
                'facebook'            => $validated['facebook'] ?? null,
                'twitter'             => $validated['twitter'] ?? null,
                'instagram'           => $validated['instagram'] ?? null,
                'linkedin'            => $validated['linkedin'] ?? null,
                'youtube'             => $validated['youtube'] ?? null,
                'display_order'       => $validated['display_order'] ?? 0,
                'is_featured'         => $request->boolean('is_featured'),
                'is_active'           => $request->boolean('is_active'),
                'published_at'        => $validated['published_at'] ?? null,
            ]);

            DB::commit();

            return redirect()
                ->route('admin.team-members.index')
                ->with('success', 'Team member created successfully.');
        } catch (\Throwable $exception) {
            DB::rollBack();

            if (isset($imagePath) && $imagePath) {
                Storage::disk('public')->delete($imagePath);
            }

            report($exception);

            return back()
                ->withInput()
                ->with('error', 'Unable to create the team member. Please try again.');
        }
    }

    /**
     * Display one team member.
     */
    public function show(TeamMember $teamMember): View
    {
        $teamMember->load('user');

        return view('admin.team-members.show', compact('teamMember'));
    }

    /**
     * Show the team-member edit form.
     */
    public function edit(TeamMember $teamMember): View
    {
        $teamMember->load('user');

        return view('admin.team-members.edit', compact('teamMember'));
    }

    /**
     * Update the user and team-member profile.
     */
    public function update(
        Request $request,
        TeamMember $teamMember
    ): RedirectResponse {
        $teamMember->load('user');

        $user = $teamMember->user;

        $validated = $request->validate([
            // User information
            'first_name' => ['required', 'string', 'max:100'],
            'last_name'  => ['required', 'string', 'max:100'],
            'email'      => [
                'required',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($user->id),
            ],
            'phone'    => ['nullable', 'string', 'max:30'],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
            'status'   => [
                'required',
                Rule::in(['active', 'inactive', 'suspended']),
            ],

            // Team-member information
            'title'      => ['nullable', 'string', 'max:50'],
            'position'   => ['required', 'string', 'max:255'],
            'department' => ['nullable', 'string', 'max:255'],
            'slug'       => [
                'nullable',
                'string',
                'max:255',
                Rule::unique('team_members', 'slug')->ignore($teamMember->id),
            ],
            'image'               => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'remove_image'        => ['nullable', 'boolean'],
            'short_bio'           => ['nullable', 'string', 'max:1000'],
            'bio'                 => ['nullable', 'string'],
            'qualification'       => ['nullable', 'string', 'max:255'],
            'specialization'      => ['nullable', 'string', 'max:255'],
            'years_of_experience' => ['nullable', 'integer', 'min:0', 'max:100'],

            // Links
            'website'   => ['nullable', 'url', 'max:255'],
            'facebook'  => ['nullable', 'url', 'max:255'],
            'twitter'   => ['nullable', 'url', 'max:255'],
            'instagram' => ['nullable', 'url', 'max:255'],
            'linkedin'  => ['nullable', 'url', 'max:255'],
            'youtube'   => ['nullable', 'url', 'max:255'],

            // Display controls
            'display_order' => ['nullable', 'integer', 'min:0'],
            'is_featured'   => ['nullable', 'boolean'],
            'is_active'     => ['nullable', 'boolean'],
            'published_at'  => ['nullable', 'date'],
        ]);

        DB::beginTransaction();

        $oldImage = $teamMember->image;
        $newImage = null;

        try {
            $userData = [
                'first_name' => $validated['first_name'],
                'last_name'  => $validated['last_name'],
                'email'      => $validated['email'],
                'phone'      => $validated['phone'] ?? null,
                'status'     => $validated['status'],
            ];

            if (!empty($validated['password'])) {
                $userData['password'] = Hash::make($validated['password']);
            }

            $user->update($userData);

            $imagePath = $oldImage;

            if ($request->boolean('remove_image')) {
                $imagePath = null;
            }

            if ($request->hasFile('image')) {
                $newImage = $request->file('image')
                    ->store('team-members', 'public');

                $imagePath = $newImage;
            }

            $requestedSlug = $validated['slug'] ?? null;

            $slugSource = $requestedSlug ?: implode(' ', [
                $validated['first_name'],
                $validated['last_name'],
            ]);

            $teamMember->update([
                'slug'                => $this->generateUniqueSlug(
                    $slugSource,
                    $teamMember->id
                ),
                'title'               => $validated['title'] ?? null,
                'position'            => $validated['position'],
                'department'          => $validated['department'] ?? null,
                'image'               => $imagePath,
                'short_bio'           => $validated['short_bio'] ?? null,
                'bio'                 => $validated['bio'] ?? null,
                'qualification'       => $validated['qualification'] ?? null,
                'specialization'      => $validated['specialization'] ?? null,
                'years_of_experience' => $validated['years_of_experience'] ?? null,
                'website'             => $validated['website'] ?? null,
                'facebook'            => $validated['facebook'] ?? null,
                'twitter'             => $validated['twitter'] ?? null,
                'instagram'           => $validated['instagram'] ?? null,
                'linkedin'            => $validated['linkedin'] ?? null,
                'youtube'             => $validated['youtube'] ?? null,
                'display_order'       => $validated['display_order'] ?? 0,
                'is_featured'         => $request->boolean('is_featured'),
                'is_active'           => $request->boolean('is_active'),
                'published_at'        => $validated['published_at'] ?? null,
            ]);

            DB::commit();

            if (
                $oldImage &&
                $oldImage !== $imagePath &&
                Storage::disk('public')->exists($oldImage)
            ) {
                Storage::disk('public')->delete($oldImage);
            }

            return redirect()
                ->route('admin.team-members.index')
                ->with('success', 'Team member updated successfully.');
        } catch (\Throwable $exception) {
            DB::rollBack();

            if (
                $newImage &&
                Storage::disk('public')->exists($newImage)
            ) {
                Storage::disk('public')->delete($newImage);
            }

            report($exception);

            return back()
                ->withInput()
                ->with('error', 'Unable to update the team member. Please try again.');
        }
    }

    /**
     * Delete the team-member profile.
     *
     * The associated user account is preserved.
     */
    public function destroy(TeamMember $teamMember): RedirectResponse
    {
        try {
            $imagePath = $teamMember->image;

            $teamMember->delete();

            if (
                $imagePath &&
                Storage::disk('public')->exists($imagePath)
            ) {
                Storage::disk('public')->delete($imagePath);
            }

            return redirect()
                ->route('admin.team-members.index')
                ->with('success', 'Team member removed successfully.');
        } catch (\Throwable $exception) {
            report($exception);

            return back()
                ->with('error', 'Unable to remove the team member.');
        }
    }

    /**
     * Generate a unique team-member slug.
     */
    private function generateUniqueSlug(
        string $value,
        ?int $ignoreId = null
    ): string {
        $baseSlug = Str::slug($value);

        if ($baseSlug === '') {
            $baseSlug = 'team-member';
        }

        $slug = $baseSlug;
        $counter = 1;

        while (
            TeamMember::query()
                ->when(
                    $ignoreId,
                    fn ($query) => $query->whereKeyNot($ignoreId)
                )
                ->where('slug', $slug)
                ->exists()
        ) {
            $slug = "{$baseSlug}-{$counter}";
            $counter++;
        }

        return $slug;
    }
}