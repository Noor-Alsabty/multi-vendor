<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        body { background-color: #f4f7f6; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
        .sidebar { height: 100vh; width: 260px; position: fixed; top: 0; left: 0; background: #2c3e50; color: white; padding-top: 20px; z-index: 1000; }
        .sidebar-brand { text-align: center; padding-bottom: 20px; border-bottom: 1px solid #3e4f5f; font-weight: bold; font-size: 1.2rem; }
        .sidebar-section { padding: 15px 20px 5px; font-size: 0.75rem; text-transform: uppercase; color: #7f8c8d; letter-spacing: 1px; }
        .sidebar a { color: #bdc3c7; text-decoration: none; padding: 10px 20px; display: block; transition: 0.3s; border-left: 4px solid transparent; }
        .sidebar a:hover { background: #34495e; color: white; border-left: 4px solid #3498db; }
        .sidebar a i { margin-right: 10px; width: 20px; }
        
        .main-content { margin-left: 260px; padding: 25px; }
        .top-navbar { background: white; padding: 10px 25px; border-radius: 8px; box-shadow: 0 2px 5px rgba(0,0,0,0.1); margin-bottom: 30px; }
        
        /* Profile Dropdown Styling */
        .profile-img { width: 35px; height: 35px; border-radius: 50%; object-fit: cover; border: 2px solid #3498db; }
        .dropdown-item i { margin-right: 8px; color: #2c3e50; }
    </style>
</head>
<body>

    <div class="sidebar shadow">
        <div class="sidebar-brand">Admin PANEL</div>
        
        <a href="{{ route('admin.index') }}"><i class="fas fa-home"></i> Dashboard</a>

        <div class="sidebar-section">catgories Management</div>
        <a href="{{ route('categories.index') }}"><i class="fas fa-box"></i> All catgories</a>
        <a href="{{ route('categories.store') }}"><i class="fas fa-plus-circle"></i> Add New catgory</a>

        <div class="sidebar-section">Orders & Shipping</div>
        <a href="#"><i class="fas fa-shopping-cart"></i> vendor Orders</a>
        <!-- <a href="#"><i class="fas fa-truck"></i> Shipping Details</a> -->

        <!-- <div class="sidebar-section">Financials</div>
        <a href="#"><i class="fas fa-wallet"></i> My Wallet</a>
        <a href="#"><i class="fas fa-hand-holding-usd"></i> Withdrawal Requests</a> -->

        <div style="margin-top: 50px;">
            <a href="#" class="text-danger"><i class="fas fa-sign-out-alt"></i> Logout</a>
        </div>
    </div>

    <div class="main-content">
        <nav class="top-navbar d-flex justify-content-between align-items-center">
            <h5 class="mb-0 text-secondary">Overview</h5>
            
            <div class="dropdown">
                <button class="btn dropdown-toggle d-flex align-items-center" type="button" id="profileMenu" data-bs-toggle="dropdown" aria-expanded="false">
                    <span class="me-2 fw-bold text-dark">admin Name</span>
                    <img src="https://via.placeholder.com/150" alt="profile" class="profile-img">
                </button>
                <ul class="dropdown-menu dropdown-menu-end shadow border-0" aria-labelledby="profileMenu">
                    <li><h6 class="dropdown-header text-primary">admin Info</h6></li>
                    <li><a class="dropdown-item" href="#"><i class="fas fa-user-circle"></i> Profile Details</a></li>
                    <!-- <li><a class="dropdown-item" href="#"><i class="fas fa-university"></i> Bank Account Info</a></li> -->
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item" href="#"><i class="fas fa-cog"></i> Settings</a></li>
                    <li><a class="dropdown-item text-danger" href="#"><i class="fas fa-power-off"></i> Logout</a></li>
                </ul>
            </div>
        </nav>

        <div class="container-fluid">
            @yield('content')
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>