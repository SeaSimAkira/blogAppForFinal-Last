@extends("layouts.app")
@section("title", "User Profile: " . $user->name)
@push("styles")
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
<style>
    body { font-family: 'Inter', sans-serif; background-color: #f4f7f9; color: #334155; }

    .user-card {
        background: white;
        border: 1px solid #e2e8f0;
        border-radius: 1.25rem;
        box-shadow: 0 5px 15px rgba(0,0,0,0.03);
    }

    /* Avatar Upload Circle */
    .avatar-upload {
        position: relative;
        max-width: 150px;
        margin: 0 auto 2rem;
    }
    .avatar-preview {
        width: 150px;
        height: 150px;
        position: relative;
        border-radius: 100%;
        border: 6px solid #f8fafc;
        box-shadow: 0px 2px 10px 0px rgba(0, 0, 0, 0.1);
        overflow: hidden;
    }
    .avatar-preview img { width: 100%; height: 100%; object-fit: cover; }

    .avatar-edit {
        position: absolute;
        right: 5px;
        bottom: 5px;
        z-index: 1;
    }
    .avatar-edit label {
        display: inline-block;
        width: 34px;
        height: 34px;
        margin-bottom: 0;
        border-radius: 100%;
        background: #4361ee;
        color: #fff;
        border: 1px solid transparent;
        box-shadow: 0px 2px 4px 0px rgba(0, 0, 0, 0.12);
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.2s ease-in-out;
    }
    .avatar-edit label:hover { background: #3a0ca3; }

    /* Role Choice Cards */
    .role-card input[type="radio"] { display: none; }
    .role-card label {
        display: block;
        padding: 1rem;
        border: 2px solid #f1f5f9;
        border-radius: 0.75rem;
        cursor: pointer;
        transition: all 0.2s;
    }
    .role-card input[type="radio"]:checked + label {
        border-color: #4361ee;
        background-color: #f0f7ff;
    }

    /* Toggle Switch */
    .form-check-input:checked { background-color: #10b981; border-color: #10b981; }
</style>
@endpush
@section("content")
<div class="container-fluid py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="user-card p-4 p-md-5 mb-4">
                <div class="d-flex justify-content-between align-items-start mb-5">
                    <div>
                        <h3 class="fw-bold mb-1">User Details</h3>
                        <p class="text-muted">Viewing account information for {{ $user->name }}</p>
                    </div>
                    <span class="badge {{ $user->is_active ? 'bg-success' : 'bg-danger' }} rounded-pill px-3 py-2">
                        {{ $user->is_active ? 'Active Account' : 'Inactive' }}
                    </span>
                </div>

                <div class="avatar-upload">
                    <div class="avatar-preview">
                        <img src="{{ $user->profile_picture ? asset('storage/' . $user->profile_picture) : 'https://ui-avatars.com/api/?name='.urlencode($user->name).'&background=f1f5f9&color=cbd5e1&size=200' }}" alt="Profile Picture">
                    </div>
                </div>

                <div class="row g-4">
                    <div class="col-md-6">
                        <label class="form-label fw-bold text-uppercase small text-muted">Full Name</label>
                        <p class="form-control-plaintext border-bottom pb-2">{{ $user->name }}</p>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-bold text-uppercase small text-muted">Email Address</label>
                        <p class="form-control-plaintext border-bottom pb-2">{{ $user->email }}</p>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-bold text-uppercase small text-muted">Account Created</label>
                        <p class="form-control-plaintext border-bottom pb-2">{{ $user->created_at->format('M d, Y') }}</p>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-bold text-uppercase small text-muted">Last Updated</label>
                        <p class="form-control-plaintext border-bottom pb-2">{{ $user->updated_at->diffForHumans() }}</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="user-card p-4 mb-4">
                <label class="form-label d-block fw-bold text-uppercase small text-muted mb-3">Assigned Role</label>
                <div class="role-card">
                    <label class="d-flex align-items-center justify-content-between border-2 border-primary bg-light shadow-sm">
                        <div>
                            <span class="d-block fw-bold text-dark text-capitalize">{{ $user->role }}</span>
                            <span class="text-muted" style="font-size: 0.75rem;">
                                @if($user->role == 'admin') Full system access @elseif($user->role == 'editor') Content management @else Standard access @endif
                            </span>
                        </div>
                        <i class="bi bi-shield-lock-fill text-primary fs-4"></i>
                    </label>
                </div>
            </div>

            <div class="d-grid gap-2">
                <a href="{{ route('users.edit', $user->id) }}" class="btn btn-primary btn-lg rounded-pill fw-bold shadow-sm">
                    <i class="bi bi-pencil-square me-2"></i> Edit Profile
                </a>

                <a href="{{ route('users.index') }}" class="btn btn-outline-secondary rounded-pill">
                    <i class="bi bi-arrow-left me-2"></i> Back to Directory
                </a>

                <hr class="my-3 text-muted">

                <form action="{{ route('users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this user?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-link text-danger w-100 text-decoration-none small">
                        <i class="bi bi-trash me-1"></i> Permanently Delete User
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
@push("scripts")
<script>
    // Profile Picture Preview
    document.getElementById('imageUpload').addEventListener('change', function() {
        const file = this.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('imagePreview').src = e.target.result;
            }
            reader.readAsDataURL(file);
        }
    });
</script>
@endpush
