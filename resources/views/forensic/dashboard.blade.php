<!-- resources/views/forensic/dashboard.blade.php -->
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forensic Dashboard</title>
    @vite(['resources/css/app.css'])
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.13.0/dist/cdn.min.js"></script>
</head>
<body class="bg-gray-900 text-white">
    <!-- Header -->
    <nav class="bg-gray-800 border-b border-red-600">
        <div class="max-w-7xl mx-auto px-4 py-4">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-red-600 rounded flex items-center justify-center">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                        </svg>
                    </div>
                    <div>
                        <h1 class="text-xl font-bold">Forensic Dashboard</h1>
                        <p class="text-xs text-gray-400">Security Investigation & Analysis</p>
                    </div>
                </div>
                <div class="flex items-center space-x-4">
                    <input type="date" value="{{ $date }}" onchange="window.location.href='?date='+this.value" class="px-3 py-2 bg-gray-700 border border-gray-600 rounded text-sm">
                    <form method="POST" action="{{ route('forensic.logout') }}">
                        <button class="px-4 py-2 bg-red-600 hover:bg-red-700 rounded text-sm">Logout</button>
                    </form>
                </div>
            </div>
        </div>
    </nav>

    <div class="max-w-7xl mx-auto px-4 py-6">
        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
            <div class="bg-gray-800 border border-gray-700 rounded-lg p-4">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-400 text-sm">Total Requests</p>
                        <p class="text-2xl font-bold text-blue-400">{{ $stats['total_requests'] }}</p>
                    </div>
                    <div class="w-12 h-12 bg-blue-900 rounded-full flex items-center justify-center">
                        <svg class="w-6 h-6 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-gray-800 border border-yellow-600 rounded-lg p-4">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-400 text-sm">Suspicious Queries</p>
                        <p class="text-2xl font-bold text-yellow-400">{{ $stats['suspicious_queries'] }}</p>
                    </div>
                    <div class="w-12 h-12 bg-yellow-900 rounded-full flex items-center justify-center">
                        <svg class="w-6 h-6 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-gray-800 border border-red-600 rounded-lg p-4">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-400 text-sm">High Severity Events</p>
                        <p class="text-2xl font-bold text-red-400">{{ $stats['high_severity_events'] }}</p>
                    </div>
                    <div class="w-12 h-12 bg-red-900 rounded-full flex items-center justify-center">
                        <svg class="w-6 h-6 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-gray-800 border border-purple-600 rounded-lg p-4">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-400 text-sm">Data Modifications</p>
                        <p class="text-2xl font-bold text-purple-400">{{ $stats['data_modifications'] }}</p>
                    </div>
                    <div class="w-12 h-12 bg-purple-900 rounded-full flex items-center justify-center">
                        <svg class="w-6 h-6 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tabs -->
        <div class="mb-6" x-data="{ activeTab: 'security' }">
            <div class="border-b border-gray-700">
                <nav class="flex space-x-4">
                    <button @click="activeTab = 'security'" :class="activeTab === 'security' ? 'border-red-500 text-red-500' : 'border-transparent text-gray-400'" class="px-4 py-3 border-b-2 font-medium text-sm">
                        🚨 Security Events ({{ count($securityEvents) }})
                    </button>
                    <button @click="activeTab = 'sql'" :class="activeTab === 'sql' ? 'border-red-500 text-red-500' : 'border-transparent text-gray-400'" class="px-4 py-3 border-b-2 font-medium text-sm">
                        💉 SQL Logs ({{ count($sqlLogs) }})
                    </button>
                    <button @click="activeTab = 'requests'" :class="activeTab === 'requests' ? 'border-red-500 text-red-500' : 'border-transparent text-gray-400'" class="px-4 py-3 border-b-2 font-medium text-sm">
                        🌐 Request Logs ({{ count($requestLogs) }})
                    </button>
                    <button @click="activeTab = 'audit'" :class="activeTab === 'audit' ? 'border-red-500 text-red-500' : 'border-transparent text-gray-400'" class="px-4 py-3 border-b-2 font-medium text-sm">
                        📋 Audit Trails ({{ count($auditTrails) }})
                    </button>
                </nav>
            </div>

            <!-- Security Events Tab -->
            <div x-show="activeTab === 'security'" class="mt-4">
                <div class="bg-gray-800 border border-red-600 rounded-lg overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm">
                            <thead class="bg-red-900">
                                <tr>
                                    <th class="px-4 py-3 text-left">Time</th>
                                    <th class="px-4 py-3 text-left">Type</th>
                                    <th class="px-4 py-3 text-left">Severity</th>
                                    <th class="px-4 py-3 text-left">IP Address</th>
                                    <th class="px-4 py-3 text-left">User</th>
                                    <th class="px-4 py-3 text-left">Description</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-700">
                                @forelse($securityEvents as $event)
                                <tr class="hover:bg-gray-700">
                                    <td class="px-4 py-3 text-xs text-gray-400">{{ $event->created_at }}</td>
                                    <td class="px-4 py-3">
                                        <span class="px-2 py-1 bg-red-900 text-red-300 rounded text-xs">{{ $event->event_type }}</span>
                                    </td>
                                    <td class="px-4 py-3">
                                        <span class="px-2 py-1 rounded text-xs {{ $event->severity === 'critical' ? 'bg-red-600 text-white' : ($event->severity === 'high' ? 'bg-orange-600 text-white' : 'bg-yellow-600 text-white') }}">
                                            {{ strtoupper($event->severity) }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-3 font-mono text-xs">{{ $event->ip_address }}</td>
                                    <td class="px-4 py-3 text-xs">{{ $event->user_id ?? 'Guest' }}</td>
                                    <td class="px-4 py-3 text-xs text-gray-300">{{ Str::limit($event->description, 60) }}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="px-4 py-8 text-center text-gray-500">No security events today</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- SQL Logs Tab -->
            <div x-show="activeTab === 'sql'" class="mt-4">
                <div class="bg-gray-800 border border-gray-700 rounded-lg overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm">
                            <thead class="bg-gray-700">
                                <tr>
                                    <th class="px-4 py-3 text-left">Time</th>
                                    <th class="px-4 py-3 text-left">Query</th>
                                    <th class="px-4 py-3 text-left">Exec Time</th>
                                    <th class="px-4 py-3 text-left">User</th>
                                    <th class="px-4 py-3 text-left">IP</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-700">
                                @forelse($sqlLogs as $log)
                                <tr class="hover:bg-gray-700 {{ str_contains(strtoupper($log->query), 'UNION') || str_contains($log->query, 'OR') ? 'bg-red-900/20' : '' }}">
                                    <td class="px-4 py-3 text-xs text-gray-400">{{ $log->created_at }}</td>
                                    <td class="px-4 py-3 font-mono text-xs text-gray-300">{{ Str::limit($log->query, 100) }}</td>
                                    <td class="px-4 py-3 text-xs">{{ number_format($log->execution_time, 2) }}ms</td>
                                    <td class="px-4 py-3 text-xs">{{ $log->user_id ?? '-' }}</td>
                                    <td class="px-4 py-3 font-mono text-xs">{{ $log->ip_address }}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="px-4 py-8 text-center text-gray-500">No SQL logs</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Request Logs Tab -->
            <div x-show="activeTab === 'requests'" class="mt-4">
                <div class="bg-gray-800 border border-gray-700 rounded-lg overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm">
                            <thead class="bg-gray-700">
                                <tr>
                                    <th class="px-4 py-3 text-left">Time</th>
                                    <th class="px-4 py-3 text-left">Method</th>
                                    <th class="px-4 py-3 text-left">URL</th>
                                    <th class="px-4 py-3 text-left">Status</th>
                                    <th class="px-4 py-3 text-left">IP</th>
                                    <th class="px-4 py-3 text-left">User</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-700">
                                @forelse($requestLogs as $log)
                                <tr class="hover:bg-gray-700">
                                    <td class="px-4 py-3 text-xs text-gray-400">{{ $log->created_at }}</td>
                                    <td class="px-4 py-3">
                                        <span class="px-2 py-1 rounded text-xs {{ $log->method === 'GET' ? 'bg-blue-900 text-blue-300' : 'bg-green-900 text-green-300' }}">{{ $log->method }}</span>
                                    </td>
                                    <td class="px-4 py-3 text-xs text-gray-300">{{ Str::limit($log->url, 50) }}</td>
                                    <td class="px-4 py-3">
                                        <span class="px-2 py-1 rounded text-xs {{ $log->response_code < 400 ? 'bg-green-900 text-green-300' : 'bg-red-900 text-red-300' }}">{{ $log->response_code }}</span>
                                    </td>
                                    <td class="px-4 py-3 font-mono text-xs">{{ $log->ip_address }}</td>
                                    <td class="px-4 py-3 text-xs">{{ $log->user_id ?? 'Guest' }}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="px-4 py-8 text-center text-gray-500">No request logs</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Audit Trails Tab -->
            <div x-show="activeTab === 'audit'" class="mt-4">
                <div class="bg-gray-800 border border-gray-700 rounded-lg overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm">
                            <thead class="bg-gray-700">
                                <tr>
                                    <th class="px-4 py-3 text-left">Time</th>
                                    <th class="px-4 py-3 text-left">Table</th>
                                    <th class="px-4 py-3 text-left">Action</th>
                                    <th class="px-4 py-3 text-left">Record ID</th>
                                    <th class="px-4 py-3 text-left">User</th>
                                    <th class="px-4 py-3 text-left">IP</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-700">
                                @forelse($auditTrails as $audit)
                                <tr class="hover:bg-gray-700">
                                    <td class="px-4 py-3 text-xs text-gray-400">{{ $audit->created_at }}</td>
                                    <td class="px-4 py-3 text-xs">{{ $audit->table_name }}</td>
                                    <td class="px-4 py-3">
                                        <span class="px-2 py-1 rounded text-xs {{ $audit->action === 'create' ? 'bg-green-900 text-green-300' : ($audit->action === 'update' ? 'bg-yellow-900 text-yellow-300' : 'bg-red-900 text-red-300') }}">
                                            {{ strtoupper($audit->action) }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-3 text-xs">{{ $audit->record_id }}</td>
                                    <td class="px-4 py-3 text-xs">{{ $audit->user_id ?? '-' }}</td>
                                    <td class="px-4 py-3 font-mono text-xs">{{ $audit->ip_address }}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="px-4 py-8 text-center text-gray-500">No audit trails</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Export Button -->
        <div class="flex justify-end">
            <a href="{{ route('forensic.export', ['date' => $date]) }}" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 rounded text-sm">
                📥 Export Logs (JSON)
            </a>
        </div>
    </div>
</body>
</html>