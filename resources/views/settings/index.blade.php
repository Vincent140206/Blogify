@extends('layouts.app')

@section('content')
<link href="{{ asset('css/settings.css') }}" rel="stylesheet">
<div class="settings-container">
    <!-- Sidebar -->
    @include('partials.sidebar')

    <div class="main-content">
        <div class="header-row">
            <h1>Settings</h1>
        </div>
        <div class="header-row-2">
            <div class="subheader">Manage your account settings and preferences</div>
        </div>

        @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
        @endif

        @if($errors->any())
        <div class="alert alert-danger">
            <ul style="margin: 0; padding-left: 20px;">
                @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <!-- My Profile Section -->
        <div class="settings-section">
            <h3 class="section-title">My Profile</h3>

            <div class="profile-image-section">
                <div class="profile-avatar">
                    @if(Auth::user()->photo_profile)
                    <img src="{{ Auth::user()->profile_photo_url }}" alt="Profile" style="width: 100%; height: 100%; border-radius: 50%; object-fit: cover;">
                    @else
                    <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                        <circle cx="12" cy="7" r="4"></circle>
                    </svg>
                    @endif
                </div>
                <div class="profile-buttons">
                    <input type="file" id="profileImageInput" accept="image/*" style="display: none;">
                    <button class="btn btn-primary" onclick="document.getElementById('profileImageInput').click()">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M12 5v14m-7-7h14"></path>
                        </svg>
                        Change Image
                    </button>
                    @if(Auth::user()->photo_profile)
                    <button class="btn btn-danger" onclick="removeProfileImage()">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M3 6h18m-2 0v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                        </svg>
                        Remove Image
                    </button>
                    @endif
                </div>
            </div>
            <div class="image-support-text">We support image file under 2MB</div>

            <form method="POST" action="{{ route('settings.update-profile') }}">
                @csrf
                @method('PUT')
                <div class="form-row">
                    <div class="form-group">
                        <label for="first_name">First Name</label>
                        <input type="text" id="first_name" name="first_name" class="form-control"
                            value="{{ old('first_name', explode(' ', Auth::user()->name)[0] ?? '') }}" required>
                    </div>
                    <div class="form-group">
                        <label for="last_name">Last Name</label>
                        <input type="text" id="last_name" name="last_name" class="form-control"
                            value="{{ old('last_name', implode(' ', array_slice(explode(' ', Auth::user()->name), 1)) ?? '') }}">
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Save Changes</button>
            </form>
        </div>

        <!-- Account Security Section -->
        <div class="settings-section">
            <h3 class="section-title">Account Security</h3>

            <div class="security-item">
                <div class="security-info">
                    <div class="security-label">Username</div>
                    <div class="security-value">{{ Auth::user()->name }}</div>
                </div>
            </div>

            <div class="security-item">
                <div class="security-info">
                    <div class="security-label">Email</div>
                    <div class="security-value">{{ Auth::user()->email }}</div>
                </div>
                <button class="btn btn-primary" onclick="openModal('emailModal')">Change email</button>
            </div>

            <div class="security-item">
                <div class="security-info">
                    <div class="security-label">Password</div>
                    <div class="security-value">••••••••••••</div>
                </div>
                <button class="btn btn-primary" onclick="openModal('passwordModal')">Change password</button>
            </div>
        </div>

        <div class="settings-section">
            <h3 class="section-title">Manage Account</h3>

            <div class="manage-item">
                <div class="manage-info">
                    <h4>Log out</h4>
                    <p>Log out from this device</p>
                </div>
                <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                    @csrf
                    <button type="submit" class="btn btn-secondary">Log out</button>
                </form>
            </div>

            <div class="manage-item">
                <div class="manage-info">
                    <h4 class="danger-text">Delete my account</h4>
                    <p>Permanently delete this account and remove access from all workspaces</p>
                </div>
                <button class="btn btn-danger" onclick="openModal('deleteModal')">Delete Account</button>
            </div>
        </div>
    </div>
</div>

<div id="emailModal" class="modal" style="display: none; position: fixed; z-index: 1000; left: 0; top: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.5);">
    <div style="background: white; margin: 15% auto; padding: 20px; border-radius: 12px; width: 400px;">
        <h4 style="margin-bottom: 20px;">Change Email Address</h4>
        <form method="POST" action="{{ route('settings.update-email') }}">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="new_email">New Email Address</label>
                <input type="email" id="new_email" name="email" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="current_password">Current Password</label>
                <input type="password" id="current_password" name="current_password" class="form-control" required>
            </div>
            <div style="display: flex; gap: 12px; justify-content: flex-end; margin-top: 20px;">
                <button type="button" class="btn btn-secondary" onclick="closeModal('emailModal')">Cancel</button>
                <button type="submit" class="btn btn-primary">Update Email</button>
            </div>
        </form>
    </div>
</div>

<div id="passwordModal" class="modal" style="display: none; position: fixed; z-index: 1000; left: 0; top: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.5);">
    <div style="background: white; margin: 15% auto; padding: 20px; border-radius: 12px; width: 400px;">
        <h4 style="margin-bottom: 20px;">Change Password</h4>
        <form method="POST" action="{{ route('settings.update-password') }}">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="current_password_change">Current Password</label>
                <input type="password" id="current_password_change" name="current_password" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="new_password">New Password</label>
                <input type="password" id="new_password" name="password" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="password_confirmation">Confirm New Password</label>
                <input type="password" id="password_confirmation" name="password_confirmation" class="form-control" required>
            </div>
            <div style="display: flex; gap: 12px; justify-content: flex-end; margin-top: 20px;">
                <button type="button" class="btn btn-secondary" onclick="closeModal('passwordModal')">Cancel</button>
                <button type="submit" class="btn btn-primary">Update Password</button>
            </div>
        </form>
    </div>
</div>

<div id="deleteModal" class="modal" style="display: none; position: fixed; z-index: 1000; left: 0; top: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.5);">
    <div style="background: white; margin: 15% auto; padding: 20px; border-radius: 12px; width: 500px;">
        <h4 style="margin-bottom: 20px; color: #dc3545;">⚠️ Delete Account</h4>
        <p style="margin-bottom: 20px; color: #666;">This action cannot be undone. This will permanently delete your account and remove all your data from our servers.</p>

        <div style="background: #fff3cd; border: 1px solid #ffeaa7; border-radius: 8px; padding: 16px; margin-bottom: 20px;">
            <strong>What will be deleted:</strong>
            <ul style="margin: 8px 0 0 20px; color: #856404;">
                <li>Your profile and account information</li>
                <li>All associated data</li>
            </ul>
        </div>

        <form method="POST" action="{{ route('settings.delete-account') }}">
            @csrf
            @method('DELETE')
            <div class="form-group">
                <label for="delete_password">Please enter your password to confirm:</label>
                <input type="password" id="delete_password" name="password" class="form-control" required
                    placeholder="Enter your current password">
            </div>
            <div class="form-group">
                <label for="delete_confirmation">Type "DELETE" to confirm:</label>
                <input type="text" id="delete_confirmation" name="confirmation" class="form-control" required
                    placeholder="Type DELETE in capital letters">
            </div>
            <div style="display: flex; gap: 12px; justify-content: flex-end; margin-top: 20px;">
                <button type="button" class="btn btn-secondary" onclick="closeModal('deleteModal')">Cancel</button>
                <button type="submit" class="btn btn-danger" id="deleteBtn" disabled>Delete My Account</button>
            </div>
        </form>
    </div>
</div>

<script>
    function handleImageUpload(event) {
        const file = event.target.files[0];
        if (file) {
            if (file.size > 2 * 1024 * 1024) {
                alert('File size must be under 2MB');
                return;
            }

            if (!file.type.startsWith('image/')) {
                alert('Please select an image file');
                return;
            }

            const formData = new FormData();
            formData.append('avatar', file);
            formData.append('_token', document.querySelector('meta[name="csrf-token"]').getAttribute('content'));

            fetch('{{ route("settings.upload-avatar") }}', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        const profileAvatar = document.querySelector('.profile-avatar');
                        profileAvatar.innerHTML = `<img src="${data.avatar_url}" alt="Profile" style="width: 100%; height: 100%; border-radius: 50%; object-fit: cover;">`;

                        const sidebarProfile = document.querySelector('.sidebar .profile');
                        if (sidebarProfile) {
                            sidebarProfile.src = data.avatar_url;
                        }

                        alert('Profile image updated successfully!');
                    } else {
                        alert('Error uploading image: ' + data.message);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Error uploading image');
                });
        }
    }

    function removeProfileImage() {
        if (confirm('Are you sure you want to remove your profile image?')) {
            fetch('{{ route("settings.remove-avatar") }}', {
                    method: 'DELETE',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        const profileAvatar = document.querySelector('.profile-avatar');
                        profileAvatar.innerHTML = `
                    <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                        <circle cx="12" cy="7" r="4"></circle>
                    </svg>
                `;

                        const sidebarProfile = document.querySelector('.sidebar .profile');
                        if (sidebarProfile) {
                            sidebarProfile.src = '{{ asset("images/profile-icon.svg") }}';
                        }

                        alert('Profile image removed successfully!');
                    } else {
                        alert('Error removing image: ' + data.message);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Error removing image');
                });
        }
    }

    function openModal(modalId) {
        document.getElementById(modalId).style.display = 'block';
    }

    function closeModal(modalId) {
        document.getElementById(modalId).style.display = 'none';
    }

    document.addEventListener('DOMContentLoaded', function() {
        const profileImageInput = document.getElementById('profileImageInput');
        if (profileImageInput) {
            profileImageInput.addEventListener('change', handleImageUpload);
        }

        window.addEventListener('click', function(event) {
            if (event.target.classList.contains('modal')) {
                event.target.style.display = 'none';
            }
        });

        const deleteConfirmationInput = document.getElementById('delete_confirmation');
        const deleteBtn = document.getElementById('deleteBtn');

        if (deleteConfirmationInput && deleteBtn) {
            deleteConfirmationInput.addEventListener('input', function() {
                if (this.value === 'DELETE') {
                    deleteBtn.disabled = false;
                    deleteBtn.style.opacity = '1';
                } else {
                    deleteBtn.disabled = true;
                    deleteBtn.style.opacity = '0.6';
                }
            });
        }

        window.addEventListener('click', function(event) {
            if (event.target.classList.contains('modal')) {
                event.target.style.display = 'none';
            }
        });
    });
</script>

@endsection