@extends('layouts.admin')
@section('title', 'Foydalanuvchilar')
@section('page-title', 'Foydalanuvchilar')

@section('content')
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-semibold text-matn flex items-center gap-2">👥 Foydalanuvchilar</h2>
        <a href="{{ route('admin.users.create') }}" class="bg-aksent hover:bg-red-600 text-white px-4 py-2 rounded-lg transition-all duration-200 transform hover:-translate-y-0.5">+ Yangi foydalanuvchi</a>
    </div>

    <!-- FILTER -->
    <form method="GET" class="bg-karta border border-chegara rounded-xl p-4 mb-6">
        <div class="flex flex-wrap gap-3 items-end">
            <input type="text" name="search" class="flex-1 min-w-[200px] px-3 py-2 bg-fon3 border border-chegara rounded-lg text-matn placeholder-matn3 focus:outline-none focus:border-aksent focus:ring-2 focus:ring-aksent/20 transition-all duration-200" placeholder="🔍 Qidirish..." value="{{ request('search') }}">
            <select name="role" class="px-3 py-2 bg-fon3 border border-chegara rounded-lg text-matn focus:outline-none focus:border-aksent focus:ring-2 focus:ring-aksent/20 transition-all duration-200">
                <option value="">Barcha rollar</option>
                <option value="user" {{ request('role') === 'user' ? 'selected' : '' }}>Foydalanuvchi</option>
                <option value="admin" {{ request('role') === 'admin' ? 'selected' : '' }}>Admin</option>
            </select>
            <select name="status" class="px-3 py-2 bg-fon3 border border-chegara rounded-lg text-matn focus:outline-none focus:border-aksent focus:ring-2 focus:ring-aksent/20 transition-all duration-200">
                <option value="">Barcha holatlar</option>
                <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Faol</option>
                <option value="blocked" {{ request('status') === 'blocked' ? 'selected' : '' }}>Bloklangan</option>
            </select>
            <button type="submit" class="bg-fon3 hover:bg-fon2 text-matn px-4 py-2 rounded-lg transition-all duration-200">Filtr</button>
            <a href="{{ route('admin.users.index') }}" class="bg-fon3 hover:bg-fon2 text-matn px-4 py-2 rounded-lg transition-all duration-200">Tozalash</a>
        </div>
    </form>

    <div class="bg-karta border border-chegara rounded-xl overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-fon3 border-b border-chegara">
                    <tr>
                        <th class="text-left py-3 px-4 text-xs font-medium text-matn2">#</th>
                        <th class="text-left py-3 px-4 text-xs font-medium text-matn2">Ism-familiya</th>
                        <th class="text-left py-3 px-4 text-xs font-medium text-matn2">Email</th>
                        <th class="text-left py-3 px-4 text-xs font-medium text-matn2">Telefon</th>
                        <th class="text-left py-3 px-4 text-xs font-medium text-matn2">Rol</th>
                        <th class="text-left py-3 px-4 text-xs font-medium text-matn2">Holat</th>
                        <th class="text-left py-3 px-4 text-xs font-medium text-matn2">Testlar</th>
                        <th class="text-left py-3 px-4 text-xs font-medium text-matn2">Sana</th>
                        <th class="text-left py-3 px-4 text-xs font-medium text-matn2">Amallar</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $i => $user)
                        <tr class="border-b border-chegara/30 hover:bg-fon3/50 transition-colors">
                            <td class="py-3 px-4 text-sm text-matn2">{{ $users->firstItem() + $i }}</td>
                            <td class="py-3 px-4">
                                <div class="flex items-center gap-2">
                                    <div class="w-7 h-7 rounded-full bg-gradient-to-br from-aksent to-red-800 flex items-center justify-center text-xs font-bold text-white flex-shrink-0">
                                        {{ $user->initials }}
                                    </div>
                                    <span class="text-sm text-matn">{{ $user->name }}</span>
                                </div>
                            </td>
                            <td class="py-3 px-4 text-sm text-matn2">{{ $user->email }}</td>
                            <td class="py-3 px-4 text-sm text-matn2">{{ $user->phone ?? '—' }}</td>
                            <td class="py-3 px-4">
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium {{
                                    $user->role === 'admin' ? 'bg-blue-500/20 text-blue-400' : 'bg-yellow-500/20 text-yellow-400'
                                }}">
                                    {{ $user->role === 'admin' ? 'Admin' : 'Foydalanuvchi' }}
                                </span>
                            </td>
                            <td class="py-3 px-4">
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium {{
                                    $user->status === 'active' ? 'bg-green-500/20 text-green-400' : 'bg-red-500/20 text-red-400'
                                }}">
                                    {{ $user->status === 'active' ? '● Faol' : '● Bloklangan' }}
                                </span>
                            </td>
                            <td class="py-3 px-4 text-sm text-matn">{{ $user->completed_tests_count ?? 0 }} ta</td>
                            <td class="py-3 px-4 text-sm text-matn2">{{ $user->created_at->format('d.m.Y') }}</td>
                            <td class="py-3 px-4">
                                <div class="flex gap-1">
                                    <a href="{{ route('admin.users.edit', $user) }}" class="bg-fon3 hover:bg-fon2 text-matn px-2 py-1 rounded text-sm transition-all duration-200" title="Tahrirlash">✏️</a>
                                    <form action="{{ route('admin.users.toggle-status', $user) }}" method="POST" class="inline">
                                        @csrf @method('PATCH')
                                        <button type="submit" class="{{
                                            $user->status === 'active' 
                                            ? 'bg-red-500/20 hover:bg-red-500/30 text-red-400' 
                                            : 'bg-green-500/20 hover:bg-green-500/30 text-green-400'
                                        }} px-2 py-1 rounded text-sm transition-all duration-200" title="{{
                                            $user->status === 'active' ? 'Bloklangan' : 'Faollashtirish'
                                        }}">
                                            {{ $user->status === 'active' ? '🚫' : '✅' }}
                                        </button>
                                    </form>
                                    @if ($user->id !== auth()->id())
                                        <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="inline"
                                            onsubmit="return confirm('Rostdan ham o\'chirmoqchimisiz?')">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="bg-red-500/20 hover:bg-red-500/30 text-red-400 px-2 py-1 rounded text-sm transition-all duration-200" title="O'chirish">🗑️</button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="text-center py-12 text-matn2">Foydalanuvchilar topilmadi</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="p-4 border-t border-chegara">
            {{ $users->appends(request()->query())->links() }}
        </div>
    </div>
@endsection
