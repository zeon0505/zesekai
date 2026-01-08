<div>
    <div class="flex justify-between items-center mb-8">
        <div>
            <h3 class="text-2xl font-black text-white uppercase tracking-tighter">User Management</h3>
            <p class="text-xs text-gray-500 font-bold uppercase tracking-widest mt-1">Manage registered users and permissions</p>
        </div>
    </div>

    @if (session()->has('message'))
        <div class="bg-green-500/10 border border-green-500/20 text-green-500 px-6 py-4 rounded-xl mb-8 flex items-center gap-3 text-sm font-bold">
            <i class="bi bi-check-circle-fill"></i>
            {{ session('message') }}
        </div>
    @endif

    <div class="bg-[#0a0a0a] rounded-2xl border border-white/5 overflow-hidden relative">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-white/[0.02] text-gray-500 text-[10px] font-black uppercase tracking-widest border-b border-white/5">
                        <th class="px-6 py-5">User</th>
                        <th class="px-6 py-5">Email</th>
                        <th class="px-6 py-5">Premium</th>
                        <th class="px-6 py-5 text-right">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-white/5">
                    @forelse($users as $user)
                        <tr class="hover:bg-white/[0.02] transition duration-200 group">
                            <td class="px-6 py-4 align-middle">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-full bg-red-600/10 flex items-center justify-center text-red-600 font-black text-xs border border-red-600/20">
                                        {{ substr($user->name, 0, 1) }}
                                    </div>
                                    <div class="text-white font-bold text-sm">{{ $user->name }}</div>
                                </div>
                            </td>
                            <td class="px-6 py-4 align-middle">
                                <div class="text-gray-400 text-xs">{{ $user->email }}</div>
                            </td>
                            <td class="px-6 py-4 align-middle">
                                <button wire:click="togglePremium({{ $user->id }})" 
                                        class="px-3 py-1 rounded text-[10px] font-black uppercase tracking-wider transition
                                        {{ $user->is_premium ? 'bg-yellow-500/10 text-yellow-500 border border-yellow-500/20' : 'bg-gray-800 text-gray-500 border border-gray-700 hover:text-white' }}">
                                    {{ $user->is_premium ? 'Premium' : 'Regular' }}
                                </button>
                            </td>
                            <td class="px-6 py-4 align-middle text-right">
                                <div class="flex justify-end gap-3 opacity-60 group-hover:opacity-100 transition-opacity">
                                    <button wire:click="delete({{ $user->id }})" 
                                            wire:confirm="Are you sure you want to delete this user?"
                                            class="text-red-600 hover:text-red-500 transition" title="Delete">
                                        <i class="bi bi-trash text-lg"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-16 text-center text-gray-700 font-bold uppercase text-xs">No users found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-6 py-4 border-t border-white/5">
            {{ $users->links() }}
        </div>
    </div>
</div>
