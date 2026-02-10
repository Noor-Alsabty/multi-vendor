@extends('layouts.app')

@section('title', 'Dashboard - Ecommerce Management System')

@section('content')
<div class="mb-8" >
    <h1 class="text-3xl font-bold text-gray-900">Dashboard</h1>
    <p class="mt-2 text-sm text-gray-600">Welcome to the Ecommerce Management System</p>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
    <!-- Departments Card -->
    <a href="{{ route('store.index') }}" class="block p-6 bg-white rounded-lg border border-gray-200 shadow-md hover:shadow-lg transition-shadow">
        <div class="flex items-center justify-between mb-4">
            <div class="p-3 bg-indigo-100 rounded-lg">
                <i class="fas fa-building text-2xl text-indigo-600"></i>
            </div>
        </div>
        <h5 class="mb-2 text-2xl font-bold text-gray-900">section</h5>
        <p class="text-gray-600">Manage Ecommerce departments</p>
    </a>

    <!-- Programs Card -->
    <!-- <a href="" class="block p-6 bg-white rounded-lg border border-gray-200 shadow-md hover:shadow-lg transition-shadow">
        <div class="flex items-center justify-between mb-4">
            <div class="p-3 bg-green-100 rounded-lg">
                <i class="fas fa-certificate text-2xl text-green-600"></i>
            </div>
        </div>
        <h5 class="mb-2 text-2xl font-bold text-gray-900">Programs</h5>
        <p class="text-gray-600">Manage academic programs</p>
    </a> -->

    <!-- Courses Card -->
    <!-- <a href="" class="block p-6 bg-white rounded-lg border border-gray-200 shadow-md hover:shadow-lg transition-shadow">
        <div class="flex items-center justify-between mb-4">
            <div class="p-3 bg-blue-100 rounded-lg">
                <i class="fas fa-book text-2xl text-blue-600"></i>
            </div>
        </div>
        <h5 class="mb-2 text-2xl font-bold text-gray-900">Courses</h5>
        <p class="text-gray-600">Browse and manage courses</p>
    </a> -->

    <!-- Instructors Card -->
    <!-- <a href="" class="block p-6 bg-white rounded-lg border border-gray-200 shadow-md hover:shadow-lg transition-shadow">
        <div class="flex items-center justify-between mb-4">
            <div class="p-3 bg-purple-100 rounded-lg">
                <i class="fas fa-chalkboard-teacher text-2xl text-purple-600"></i>
            </div>
        </div>
        <h5 class="mb-2 text-2xl font-bold text-gray-900">Instructors</h5>
        <p class="text-gray-600">View instructor directory</p>
    </a> -->

    <!-- Students Card -->
    <!-- <a href="" class="block p-6 bg-white rounded-lg border border-gray-200 shadow-md hover:shadow-lg transition-shadow">
        <div class="flex items-center justify-between mb-4">
            <div class="p-3 bg-yellow-100 rounded-lg">
                <i class="fas fa-user-graduate text-2xl text-yellow-600"></i>
            </div>
        </div>
        <h5 class="mb-2 text-2xl font-bold text-gray-900">Students</h5>
        <p class="text-gray-600">Manage student records</p>
    </a> -->

    <!-- Sections Card -->
    <!-- <a href="" class="block p-6 bg-white rounded-lg border border-gray-200 shadow-md hover:shadow-lg transition-shadow">
        <div class="flex items-center justify-between mb-4">
            <div class="p-3 bg-red-100 rounded-lg">
                <i class="fas fa-users-class text-2xl text-red-600"></i>
            </div>
        </div>
        <h5 class="mb-2 text-2xl font-bold text-gray-900">Sections</h5>
        <p class="text-gray-600">View course sections</p>
    </a> -->

    <!-- Enrollments Card -->
    <!-- <a href="" class="block p-6 bg-white rounded-lg border border-gray-200 shadow-md hover:shadow-lg transition-shadow">
        <div class="flex items-center justify-between mb-4">
            <div class="p-3 bg-pink-100 rounded-lg">
                <i class="fas fa-user-check text-2xl text-pink-600"></i>
            </div>
        </div>
        <h5 class="mb-2 text-2xl font-bold text-gray-900">Enrollments</h5>
        <p class="text-gray-600">Student enrollments</p>
    </a> -->

    <!-- Assignments Card -->
    <!-- <a href="" class="block p-6 bg-white rounded-lg border border-gray-200 shadow-md hover:shadow-lg transition-shadow">
        <div class="flex items-center justify-between mb-4">
            <div class="p-3 bg-teal-100 rounded-lg">
                <i class="fas fa-tasks text-2xl text-teal-600"></i>
            </div>
        </div>
        <h5 class="mb-2 text-2xl font-bold text-gray-900">Assignments</h5>
        <p class="text-gray-600">Course assignments</p>
    </a> -->

    <!-- Submissions Card -->
    <!-- <a href="" class="block p-6 bg-white rounded-lg border border-gray-200 shadow-md hover:shadow-lg transition-shadow">
        <div class="flex items-center justify-between mb-4">
            <div class="p-3 bg-orange-100 rounded-lg">
                <i class="fas fa-file-upload text-2xl text-orange-600"></i>
            </div>
        </div>
        <h5 class="mb-2 text-2xl font-bold text-gray-900">Submissions</h5>
        <p class="text-gray-600">Assignment submissions</p>
    </a> -->
</div>
@endsection

