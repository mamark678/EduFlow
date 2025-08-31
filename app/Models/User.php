<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'email_verified',
        'email_verification_code',
        'email_verification_expires_at',
        'login_otp',
        'login_otp_expires_at',
        'avatar',
        'last_login_at',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'email_verified' => 'boolean',
            'email_verification_expires_at' => 'datetime',
            'login_otp_expires_at' => 'datetime',
            'last_login_at' => 'datetime',
        ];
    }

    public function courses()
    {
        return $this->hasMany(Course::class, 'instructor_id');
    }

    public function enrollments()
    {
        return $this->hasMany(Enrollment::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }

    public function unreadNotifications()
    {
        return $this->notifications()->unread();
    }

    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    public function isInstructor()
    {
        return $this->role === 'instructor';
    }

    public function isStudent()
    {
        return $this->role === 'student';
    }

    public function scopeStudents($query)
    {
        return $query->where('role', 'student');
    }

    public function scopeInstructors($query)
    {
        return $query->where('role', 'instructor');
    }

    public function scopeAdmins($query)
    {
        return $query->where('role', 'admin');
    }

    /**
     * Get the URL to the user's avatar.
     * Returns the avatar URL or a default avatar if not set.
     */
    public function getAvatarUrlAttribute()
    {
        if ($this->avatar) {
            // Check if it's a base64 data URL
            if (str_starts_with($this->avatar, 'data:')) {
                return $this->avatar;
            }
            // Check if it's a file path (for backward compatibility)
            if (Storage::disk('public')->exists('avatars/' . $this->avatar)) {
                return Storage::disk('public')->url('avatars/' . $this->avatar);
            }
            // Log if file doesn't exist but avatar field is set
            \Log::warning('Avatar file not found: ' . $this->avatar);
        }
        return null; // No avatar, let UI show fallback
    }

    public function moduleProgresses()
    {
        return $this->hasMany(\App\Models\ModuleProgress::class);
    }

    // Forum relationships
    public function forumPosts()
    {
        return $this->hasMany(ForumPost::class);
    }

    public function forumComments()
    {
        return $this->hasMany(ForumComment::class);
    }

    public function createdForums()
    {
        return $this->hasMany(Forum::class, 'created_by_user_id');
    }

    public function forumModerators()
    {
        return $this->hasMany(ForumModerator::class);
    }

    public function forumMembers()
    {
        return $this->hasMany(ForumMember::class);
    }

    public function forumFlairs()
    {
        return $this->hasMany(ForumUserFlair::class);
    }

    public function forumUserFlair()
    {
        return $this->hasOne(ForumUserFlair::class)->active();
    }

    public function votes()
    {
        return $this->hasMany(ForumVote::class);
    }
}
