<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Social Media Admin Dashboard - Activity</title>
    <link rel="stylesheet" href="/public/css/admin_activity.css">
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
                <h1 class="text-2xl font-bold mb-4">Activity</h1>
                <div class="card">
                    <div class="card-title">Recent Activity</div>
                    <ul class="activity-list">
                        <li class="activity-item">
                            <div class="activity-content">
                                <span>User John Doe liked a post</span>
                            </div>
                            <span class="activity-time">2 minutes ago</span>
                        </li>
                        <li class="activity-item">
                            <div class="activity-content">
                                <span>User Jane Smith commented on a photo</span>
                            </div>
                            <span class="activity-time">15 minutes ago</span>
                        </li>
                        <li class="activity-item">
                            <div class="activity-content">
                                <span>User Mike Johnson shared a post</span>
                            </div>
                            <span class="activity-time">1 hour ago</span>
                        </li>
                        <li class="activity-item">
                            <div class="activity-content">
                                <span>User Sarah Williams updated their profile picture</span>
                            </div>
                            <span class="activity-time">2 hours ago</span>
                        </li>
                        <li class="activity-item">
                            <div class="activity-content">
                                <span>User Tom Brown created a new event</span>
                            </div>
                            <span class="activity-time">3 hours ago</span>
                        </li>
                    </ul>
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
    </script>
</body>
</html>