<!DOCTYPE html>
<html lang="en" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Ecommerce Management System')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body class="bg-light">
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
        <div class="container-fluid">
            <a class="navbar-brand fw-bold text-primary" href="{{ route('dashboard') }}">
                <i class="fas fa-graduation-cap me-2"></i>Ecommerce System
            </a>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="d-flex min-vh-100">
        <!-- Sidebar -->
        <aside class="bg-white shadow-sm" style="width: 250px; min-height: 100vh;">
            <div class="p-3">
                <h6 class="text-muted text-uppercase small fw-bold mb-3">Management</h6>
                <nav class="nav flex-column">
                    <a href="{{ route('store.index') }}"
                        class="nav-link py-2 {{ request()->routeIs('store.*') ? 'active' : '' }}">
                        <i class="fas fa-building me-2"></i> الأقسام
                    </a>
                    <a href=""
                   
                    >
                        <i class="fas fa-certificate me-2"></i>Programs
                    </a>
                    <a href=""
                  
                    >
                        <i class="fas fa-book me-2"></i>Courses
                    </a>
                    <a href=""
                   
                
                    
                    >
                        <i class="fas fa-link me-2"></i>Prerequisites
                    </a>
                    <a href=""
                    
                    >
                        <i class="fas fa-calendar me-2"></i>Semesters
                    </a>
                    <a href=""
                     

                    

                    >
                        <i class="fas fa-door-open me-2"></i>Classrooms
                    </a>
                    <a href=""
                       
                    >
                        <i class="fas fa-users me-2"></i>Sections
                    </a>
                </nav>

                <h6 class="text-muted text-uppercase small fw-bold mt-4 mb-3">People</h6>
                <nav class="nav flex-column">
                    <a href="
                    "
                   
                    >
                        <i class="fas fa-chalkboard-teacher me-2"></i>Instructors
                    </a>
                    <a href=""
                    
                    >
                        <i class="fas fa-briefcase me-2"></i>Offices
                    </a>
                    <a href=""
                    
                    >
                        <i class="fas fa-user-graduate me-2"></i>Students
                    </a>
                </nav>

                <h6 class="text-muted text-uppercase small fw-bold mt-4 mb-3">Activities</h6>
                <nav class="nav flex-column">
                    <a href=""
               
                    
                        >
                        <i class="fas fa-user-check me-2"></i>Enrollments
                    </a>
                    <a href=""
                       >
                        <i class="fas fa-user-tie me-2"></i>Teacher Assignments
                    </a>
                    <a href="">

            
                        <i class="fas fa-tasks me-2"></i>Assignments
                    </a>
              
                        <i class="fas fa-file-upload me-2"></i>Submissions
                    </a>
                </nav>

                <h6 class="text-muted text-uppercase small fw-bold mt-4 mb-3">Developer Tools</h6>
                <nav class="nav flex-column">
                 
                     
                        <i class="fas fa-database me-2"></i>Schema Visualizer
                    </a>
                </nav>
            </div>
        </aside>

        <!-- Content Area -->
        <main class="flex-fill p-4">
            @yield('content')
        </main>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
