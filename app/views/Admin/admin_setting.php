<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Social Media Admin Dashboard - Settings</title>
    <link rel="stylesheet" href="/public/css/admin_setting.css">
</head>
<body>
<div class="container">
        <aside class="sidebar">
            <div class="sidebar-header">
                <a href="index.html" class="sidebar-button">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"></polyline></svg>
                    Social Media Dashboard
                </a>
            </div>
            <div class="sidebar-content">
                <a href="/Admin/admin_dashboard" class="sidebar-button">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m3 9 9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg>
                    Overview
                </a>
                <a href="/Admin/admin_activity" class="sidebar-button">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path></svg>
                    Activity
                </a>
                <a href="/Admin/admin_users" class="sidebar-button">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>
                    Users
                </a>
                <a href="/Admin/admin_notification" class="sidebar-button">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path></svg>
                    Notifications
                </a>
                <a href="/Admin/admin_setting" class="sidebar-button">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12.22 2h-.44a2 2 0 0 0-2 2v.18a2 2 0 0 1-1 1.73l-.43.25a2 2 0 0 1-2 0l-.15-.08a2 2 0 0 0-2.73.73l-.22.38a2 2 0 0 0 .73 2.73l.15.1a2 2 0 0 1 1 1.72v.51a2 2 0 0 1-1 1.74l-.15.09a2 2 0 0 0-.73 2.73l.22.38a2 2 0 0 0 2.73.73l.15-.08a2 2 0 0 1 2 0l.43.25a2 2 0 0 1 1 1.73V20a2 2 0 0 0 2 2h.44a2 2 0 0 0 2-2v-.18a2 2 0 0 1 1-1.73l.43-.25a2 2 0 0 1 2 0l.15.08a2 2 0 0 0 2.73-.73l.22-.39a2 2 0 0 0-.73-2.73l-.15-.08a2 2 0 0 1-1-1.74v-.5a2 2 0 0 1 1-1.74l.15-.09a2 2 0 0 0 .73-2.73l-.22-.38a2 2 0 0 0-2.73-.73l-.15.08a2 2 0 0 1-2 0l-.43-.25a2 2 0 0 1-1-1.73V4a2 2 0 0 0-2-2z"></path><circle cx="12" cy="12" r="3"></circle></svg>
                    Settings
                </a>
            </div>
        </aside>
        <div class="main-content">
            <header class="header">
                <div class="logo">Social Media Dashboard</div>
                <div class="user-info">
                    <span>Username</span>
                    <div class="user-avatar"></div>
                </div>
            </header>
            <main>
                <h1 class="text-2xl font-bold mb-4">Settings</h1>
                <div class="card">
                    <div class="card-title">Account Settings</div>
                    <form class="settings-form">
                        <div class="form-group">
                            <label for="username">Username</label>
                            <input type="text" id="username" name="username" value="current_username">
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" id="email" name="email" value="user@example.com">
                        </div>
                        <div class="form-group">
                            <label for="language">Language</label>
                            <select id="language" name="language">
                                <option value="en">English</option>
                                <option value="es">Español</option>
                                <option value="fr">Français</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>
                                <input type="checkbox" name="notifications" checked>
                                Enable email notifications
                            </label>
                        </div>
                        <div class="form-group">
                            <label>
                                <input type="checkbox" name="dark_mode">
                                Enable dark mode
                            </label>
                        </div>
                        <button type="submit" class="button">Save Changes</button>
                    </form>
                </div>
            </main>
        </div>
    </div>
    <script>

        // Highlight active page in sidebar
        const currentPage = window.location.pathname.split('/').pop();
        const sidebarButtons = document.querySelectorAll('.sidebar-button');
        sidebarButtons.forEach(button => {
            if (button.getAttribute('href') === currentPage) {
                button.style.backgroundColor = 'hsl(var(--accent))';
                button.style.fontWeight = 'bold';
            }
        });

        // Form submission (prevent default for demo)
        const form = document.querySelector('.settings-form');
        form.addEventListener('submit', (e) => {
            e.preventDefault();
            alert('Settings saved!');
        });
    </script>
</body>
</html>