@extends('layouts.admin')
@section('title', 'Foydalanuvchilar')
@section('page-title', 'Foydalanuvchilar')

@section('content')
    <div class="section-sarlavha">
        <h2>👥 Foydalanuvchilar</h2>
        <a href="{{ route('admin.users.create') }}" class="btn btn-asosiy">+ Yangi foydalanuvchi</a>
    </div>

    <!-- FILTER -->
    <form method="GET" class="filter-qator">
        <input type="text" name="search" class="form-input" placeholder="🔍 Qidirish..." value="{{ request('search') }}">
        <select name="role" class="form-input" style="max-width:160px;">
            <option value="">Barcha rollar</option>
            <option value="user" {{ request('role') === 'user' ? 'selected' : '' }}>Foydalanuvchi</option>
            <option value="admin" {{ request('role') === 'admin' ? 'selected' : '' }}>Admin</option>
        </select>
        <select name="status" class="form-input" style="max-width:160px;">
            <option value="">Barcha holatlar</option>
            <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Faol</option>
            <option value="blocked" {{ request('status') === 'blocked' ? 'selected' : '' }}>Bloklangan</option>
        </select>
        <button type="submit" class="btn btn-ikkinchi">Filtr</button>
        <a href="{{ route('admin.users.index') }}" class="btn btn-ikkinchi">Tozalash</a>
    </form>

    <div class="karta">
        <div class="jadval-wrapper">
            <table>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Ism-familiya</th>
                        <th>Email</th>
                        <th>Telefon</th>
                        <th>Rol</th>
                        <th>Holat</th>
                        <th>Testlar</th>
                        <th>Sana</th>
                        <th>Amallar</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $i => $user)
                        <tr>
                            <td style="color:var(--matn2);">{{ $users->firstItem() + $i }}</td>
                            <td>
                                <div style="display:flex;align-items:center;gap:8px;">
                                    <div
                                        style="width:30px;height:30px;border-radius:50%;background:var(--aksent);display:flex;align-items:center;justify-content:center;font-size:.7rem;font-weight:700;flex-shrink:0;">
                                        {{ $user->initials }}
                                    </div>
                                    {{ $user->name }}
                                </div>
                            </td>
                            <td style="color:var(--matn2);">{{ $user->email }}</td>
                            <td style="color:var(--matn2);">{{ $user->phone ?? '—' }}</td>
                            <td>
                                <span class="chip {{ $user->role === 'admin' ? 'chip-moviy' : 'chip-sariq' }}">
                                    {{ $user->role === 'admin' ? 'Admin' : 'Foydalanuvchi' }}
                                </span>
                            </td>
                            <td>
                                <span class="chip {{ $user->status === 'active' ? 'chip-yashil' : 'chip-qizil' }}">
                                    {{ $user->status === 'active' ? '● Faol' : '● Bloklangan' }}
                                </span>
                            </td>
                            <td>{{ $user->completed_tests_count ?? 0 }} ta</td>
                            <td style="color:var(--matn2);">{{ $user->created_at->format('d.m.Y') }}</td>
                            <td>
                                <div style="display:flex;gap:5px;">
                                    <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-ikkinchi btn-sm">✏️</a>
                                    <form action="{{ route('admin.users.toggle-status', $user) }}" method="POST"
                                        style="display:inline;">
                                        @csrf @method('PATCH')
                                        <button type="submit"
                                            class="btn btn-sm {{ $user->status === 'active' ? 'btn-xavf' : 'btn-yashil' }}">
                                            {{ $user->status === 'active' ? '🚫' : '✅' }}
                                        </button>
                                    </form>
                                    @if ($user->id !== auth()->id())
                                        <form action="{{ route('admin.users.destroy', $user) }}" method="POST"
                                            style="display:inline;"
                                            onsubmit="return confirm('Rostdan ham o\'chirmoqchimisiz?')">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="btn btn-xavf btn-sm">🗑️</button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" style="text-align:center;padding:40px;color:var(--matn2);">Foydalanuvchilar
                                topilmadi</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        {{ $users->appends(request()->query())->links() }}
    </div>
@endsection
