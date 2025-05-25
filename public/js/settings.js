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