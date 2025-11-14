<!-- ========================================== -->
<!-- resources/views/layouts/navigation.blade.php -->
<!-- Navigation Component -->
<!-- ========================================== -->

<nav class="bg-white shadow-lg border-b border-gray-200" x-data="{ mobileMenuOpen: false }">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="flex-shrink-0 flex items-center">
                    <a href="@if(auth()->user()->isAdmin()){{ route('admin.dashboard') }}@elseif(auth()->user()->isDoctor()){{ route('doctor.dashboard') }}@else{{ route('patient.dashboard') }}@endif" 
                       class="flex items-center space-x-2">
                        <img src="https://img.freepik.com/vektor-gratis/vektor-desain-logo-rumah-sakit-salib-medis_53876-136743.jpg?semt=ais_hybrid&w=740&q=80" class="w-10 h-10" />
                        <span class="text-xl font-bold text-primary-600 hidden sm:block">Klinik Sehat</span>
                    </a>
                </div>
                
                <!-- Desktop Menu -->
                <div class="hidden sm:ml-6 sm:flex sm:space-x-8">
                    @if(auth()->user()->isAdmin())
                        <a href="{{ route('admin.dashboard') }}" 
                           class="border-transparent text-gray-500 hover:border-primary-500 hover:text-gray-700 inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium transition
                           {{ request()->routeIs('admin.dashboard') ? 'border-primary-500 text-gray-900' : '' }}">
                            <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                            </svg>
                            Dashboard
                        </a>
                        <a href="{{ route('admin.patients.index') }}" 
                           class="border-transparent text-gray-500 hover:border-primary-500 hover:text-gray-700 inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium transition
                           {{ request()->routeIs('admin.patients.*') ? 'border-primary-500 text-gray-900' : '' }}">
                            <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                            </svg>
                            Pasien
                        </a>
                        <a href="{{ route('admin.doctors.index') }}" 
                           class="border-transparent text-gray-500 hover:border-primary-500 hover:text-gray-700 inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium transition
                           {{ request()->routeIs('admin.doctors.*') ? 'border-primary-500 text-gray-900' : '' }}">
                            <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                            </svg>
                            Dokter
                        </a>
                    @elseif(auth()->user()->isDoctor())
                        <a href="{{ route('doctor.dashboard') }}" 
                           class="border-transparent text-gray-500 hover:border-primary-500 hover:text-gray-700 inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium transition
                           {{ request()->routeIs('doctor.dashboard') ? 'border-primary-500 text-gray-900' : '' }}">
                            <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                            </svg>
                            Dashboard
                        </a>
                        <a href="{{ route('doctor.medical-records.index') }}" 
                           class="border-transparent text-gray-500 hover:border-primary-500 hover:text-gray-700 inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium transition
                           {{ request()->routeIs('doctor.medical-records.*') ? 'border-primary-500 text-gray-900' : '' }}">
                            <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            Rekam Medis
                        </a>
                        <a href="{{ route('doctor.appointments.index') }}" 
                           class="border-transparent text-gray-500 hover:border-primary-500 hover:text-gray-700 inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium transition
                           {{ request()->routeIs('doctor.appointments.*') ? 'border-primary-500 text-gray-900' : '' }}">
                            <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                            Jadwal
                        </a>
                    @else
                        <a href="{{ route('patient.dashboard') }}" 
                           class="border-transparent text-gray-500 hover:border-primary-500 hover:text-gray-700 inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium transition
                           {{ request()->routeIs('patient.dashboard') ? 'border-primary-500 text-gray-900' : '' }}">
                            <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                            </svg>
                            Dashboard
                        </a>
                        <a href="{{ route('patient.appointments.index') }}" 
                           class="border-transparent text-gray-500 hover:border-primary-500 hover:text-gray-700 inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium transition
                           {{ request()->routeIs('patient.appointments.*') ? 'border-primary-500 text-gray-900' : '' }}">
                            <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                            Janji Temu
                        </a>
                        <a href="{{ route('patient.medical-records.index') }}" 
                           class="border-transparent text-gray-500 hover:border-primary-500 hover:text-gray-700 inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium transition
                           {{ request()->routeIs('patient.medical-records.*') ? 'border-primary-500 text-gray-900' : '' }}">
                            <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            Rekam Medis
                        </a>
                    @endif
                </div>
            </div>
            
            <!-- Right side -->
            <div class="hidden sm:ml-6 sm:flex sm:items-center space-x-4">
                <!-- Role Badge -->
                <span class="px-3 py-1 text-xs font-semibold rounded-full bg-primary-500 text-white">
                    {{ ucfirst(auth()->user()->role) }}
                </span>
                
                <!-- User Dropdown -->
                <div class="ml-3 relative" x-data="{ open: false }">
                    <button @click="open = !open" class="flex items-center space-x-4 p-2 text-sm rounded-full focus:outline-none focus:ring-1 focus:ring-primary-500">
                        <div class="h-10 w-10 rounded-full bg-primary-600 flex items-center justify-center text-white font-semibold">
                            {{ substr(auth()->user()->name, 0, 1) }}
                        </div>
                        <span class="hidden md:block font-medium text-gray-700">{{ auth()->user()->name }}</span>
                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>
                    
                    <div x-show="open" 
                         @click.away="open = false"
                         x-transition
                         class="origin-top-right absolute right-0 mt-2 w-56 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 divide-y divide-gray-100">
                        <div class="px-4 py-3">
                            <p class="text-sm font-medium text-gray-900">{{ auth()->user()->name }}</p>
                            <p class="text-xs text-gray-500 truncate">{{ auth()->user()->email }}</p>
                        </div>
                        <div class="py-1">
                            @if(auth()->user()->isPatient())
                                <a href="{{ route('patient.profile') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                    <svg class="w-4 h-4 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                    </svg>
                                    Profil Saya
                                </a>
                            @endif
                            <form method="POST" action="{{ route('logout') }}">
                                <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50">
                                    <svg class="w-4 h-4 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                                    </svg>
                                    Logout
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Mobile menu button -->
            <div class="flex items-center sm:hidden">
                <button @click="mobileMenuOpen = !mobileMenuOpen" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path x-show="!mobileMenuOpen" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path x-show="mobileMenuOpen" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" style="display: none;" />
                    </svg>
                </button>
            </div>
        </div>
    </div>
    
    <!-- Mobile menu -->
    <div x-show="mobileMenuOpen" class="sm:hidden" style="display: none;">
        <div class="pt-2 pb-3 space-y-1">
            @if(auth()->user()->isAdmin())
                <a href="{{ route('admin.dashboard') }}" class="block pl-3 pr-4 py-2 border-l-4 text-base font-medium {{ request()->routeIs('admin.dashboard') ? 'border-primary-500 text-primary-700 bg-primary-50' : 'border-transparent text-gray-600 hover:bg-gray-50 hover:border-gray-300' }}">
                    Dashboard
                </a>
                <a href="{{ route('admin.patients.index') }}" class="block pl-3 pr-4 py-2 border-l-4 text-base font-medium {{ request()->routeIs('admin.patients.*') ? 'border-primary-500 text-primary-700 bg-primary-50' : 'border-transparent text-gray-600 hover:bg-gray-50 hover:border-gray-300' }}">
                    Pasien
                </a>
                <a href="{{ route('admin.doctors.index') }}" class="block pl-3 pr-4 py-2 border-l-4 text-base font-medium {{ request()->routeIs('admin.doctors.*') ? 'border-primary-500 text-primary-700 bg-primary-50' : 'border-transparent text-gray-600 hover:bg-gray-50 hover:border-gray-300' }}">
                    Dokter
                </a>
            @elseif(auth()->user()->isDoctor())
                <a href="{{ route('doctor.dashboard') }}" class="block pl-3 pr-4 py-2 border-l-4 text-base font-medium {{ request()->routeIs('doctor.dashboard') ? 'border-primary-500 text-primary-700 bg-primary-50' : 'border-transparent text-gray-600 hover:bg-gray-50 hover:border-gray-300' }}">
                    Dashboard
                </a>
                <a href="{{ route('doctor.medical-records.index') }}" class="block pl-3 pr-4 py-2 border-l-4 text-base font-medium {{ request()->routeIs('doctor.medical-records.*') ? 'border-primary-500 text-primary-700 bg-primary-50' : 'border-transparent text-gray-600 hover:bg-gray-50 hover:border-gray-300' }}">
                    Rekam Medis
                </a>
                <a href="{{ route('doctor.appointments.index') }}" class="block pl-3 pr-4 py-2 border-l-4 text-base font-medium {{ request()->routeIs('doctor.appointments.*') ? 'border-primary-500 text-primary-700 bg-primary-50' : 'border-transparent text-gray-600 hover:bg-gray-50 hover:border-gray-300' }}">
                    Jadwal
                </a>
            @else
                <a href="{{ route('patient.dashboard') }}" class="block pl-3 pr-4 py-2 border-l-4 text-base font-medium {{ request()->routeIs('patient.dashboard') ? 'border-primary-500 text-primary-700 bg-primary-50' : 'border-transparent text-gray-600 hover:bg-gray-50 hover:border-gray-300' }}">
                    Dashboard
                </a>
                <a href="{{ route('patient.appointments.index') }}" class="block pl-3 pr-4 py-2 border-l-4 text-base font-medium {{ request()->routeIs('patient.appointments.*') ? 'border-primary-500 text-primary-700 bg-primary-50' : 'border-transparent text-gray-600 hover:bg-gray-50 hover:border-gray-300' }}">
                    Janji Temu
                </a>
                <a href="{{ route('patient.medical-records.index') }}" class="block pl-3 pr-4 py-2 border-l-4 text-base font-medium {{ request()->routeIs('patient.medical-records.*') ? 'border-primary-500 text-primary-700 bg-primary-50' : 'border-transparent text-gray-600 hover:bg-gray-50 hover:border-gray-300' }}">
                    Rekam Medis
                </a>
            @endif
        </div>
        <div class="pt-4 pb-3 border-t border-gray-200">
            <div class="px-4">
                <div class="flex items-center">
                    <div class="h-10 w-10 rounded-full bg-primary-600 flex items-center justify-center text-white font-semibold">
                        {{ substr(auth()->user()->name, 0, 1) }}
                    </div>
                    <div class="ml-3">
                        <div class="text-base font-medium text-gray-800">{{ auth()->user()->name }}</div>
                        <div class="text-sm text-gray-500">{{ auth()->user()->email }}</div>
                    </div>
                </div>
            </div>
            <div class="mt-3 space-y-1">
                @if(auth()->user()->isPatient())
                    <a href="{{ route('patient.profile') }}" class="block px-4 py-2 text-base font-medium text-gray-600 hover:bg-gray-100">
                        Profil Saya
                    </a>
                @endif
                <form method="POST" action="{{ route('logout') }}">
                    <button type="submit" class="block w-full text-left px-4 py-2 text-base font-medium text-red-600 hover:bg-red-50">
                        Logout
                    </button>
                </form>
            </div>
        </div>
    </div>
</nav>