@extends('layouts.app')

@section('title', 'Detail Permintaan Barang')

@section('header')
    <div class="flex items-center justify-between">
        <h1 class="text-2xl font-bold text-gray-900">Detail Permintaan Barang</h1>
        <div>
            <a href="{{ route('item-requests.index') }}"
                class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                <i class="fas fa-arrow-left mr-2"></i> Kembali
            </a>
        </div>
    </div>
@endsection

@section('content')
    <div class="grid grid-cols-1 gap-6">
        <!-- Informasi Permintaan -->
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-medium text-gray-900">Informasi Permintaan</h3>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-500">Barang</label>
                        <p class="mt-1 text-sm text-gray-900">{{ $itemRequest->item->name }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-500">Jumlah</label>
                        <p class="mt-1 text-sm text-gray-900">{{ $itemRequest->quantity }}
                            {{ $itemRequest->item->unit->symbol }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-500">Peminta</label>
                        <p class="mt-1 text-sm text-gray-900">{{ $itemRequest->user->name }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-500">Tanggal Permintaan</label>
                        <p class="mt-1 text-sm text-gray-900">{{ $itemRequest->created_at->format('d M Y H:i') }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-500">Status</label>
                        <p class="mt-1 text-sm text-gray-900">
                            @if ($itemRequest->status === 'pending')
                                <span
                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">Pending</span>
                            @elseif($itemRequest->status === 'approved')
                                <span
                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">Disetujui</span>
                            @else
                                <span
                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">Ditolak</span>
                            @endif
                        </p>
                    </div>
                    @if ($itemRequest->status !== 'pending')
                        <div>
                            <label class="block text-sm font-medium text-gray-500">Diproses Oleh</label>
                            <p class="mt-1 text-sm text-gray-900">{{ $itemRequest->processedBy->name ?? '-' }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-500">Tanggal Diproses</label>
                            <p class="mt-1 text-sm text-gray-900">{{ $itemRequest->processed_at->format('d M Y H:i') }}</p>
                        </div>
                    @endif
                    @if ($itemRequest->status === 'rejected')
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-500">Alasan Penolakan</label>
                            <p class="mt-1 text-sm text-gray-900">{{ $itemRequest->rejection_reason }}</p>
                        </div>
                    @endif
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-500">Alasan Permintaan</label>
                        <p class="mt-1 text-sm text-gray-900">{{ $itemRequest->reason }}</p>
                    </div>
                </div>
            </div>
        </div>

        @if ($itemRequest->status === 'approved')
            <!-- Detail Transaksi -->
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">Detail Transaksi</h3>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-500">Jenis Transaksi</label>
                            <p class="mt-1 text-sm text-gray-900">Keluar (Barang dikeluarkan dari stok)</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-500">Jumlah</label>
                            <p class="mt-1 text-sm text-gray-900">{{ $itemRequest->quantity }}
                                {{ $itemRequest->item->unit->symbol }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-500">Diproses Oleh</label>
                            <p class="mt-1 text-sm text-gray-900">{{ $itemRequest->processedBy->name }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-500">Tanggal Diproses</label>
                            <p class="mt-1 text-sm text-gray-900">{{ $itemRequest->processed_at->format('d M Y H:i') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        @if (auth()->user()->isAdmin() && $itemRequest->status === 'pending')
            <div class="flex justify-end space-x-4">
                <form action="{{ route('item-requests.approve', $itemRequest->id) }}" method="POST">
                    @csrf
                    <button type="submit"
                        class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                        <i class="fas fa-check mr-2"></i> Setujui Permintaan
                    </button>
                </form>
                <button onclick="openRejectModal()" type="button"
                    class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                    <i class="fas fa-times mr-2"></i> Tolak Permintaan
                </button>
            </div>

            <!-- Reject Modal -->
            <div id="reject-modal" class="fixed z-10 inset-0 overflow-y-auto hidden" aria-labelledby="modal-title"
                role="dialog" aria-modal="true">
                <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                    <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>
                    <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                    <div
                        class="inline-block align-bottom bg-white rounded-lg px-4 pt-5 pb-4 text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full sm:p-6">
                        <div>
                            <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">Tolak Permintaan</h3>
                            <div class="mt-2">
                                <form id="reject-form" action="{{ route('item-requests.reject', $itemRequest->id) }}"
                                    method="POST">
                                    @csrf
                                    <div class="mb-4">
                                        <label for="rejection_reason" class="block text-sm font-medium text-gray-700">Alasan
                                            penolakan</label>
                                        <textarea name="rejection_reason" id="rejection_reason" rows="3" required
                                            class="mt-1 focus:ring-primary-500 focus:border-primary-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md px-3 py-2 border"></textarea>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="mt-5 sm:mt-6 sm:grid sm:grid-cols-2 sm:gap-3 sm:grid-flow-row-dense">
                            <button type="button" onclick="document.getElementById('reject-form').submit();"
                                class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:col-start-2 sm:text-sm">
                                Tolak
                            </button>
                            <button type="button" onclick="closeRejectModal()"
                                class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 sm:mt-0 sm:col-start-1 sm:text-sm">
                                Batal
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <script>
                function openRejectModal() {
                    document.getElementById('reject-modal').classList.remove('hidden');
                }

                function closeRejectModal() {
                    document.getElementById('reject-modal').classList.add('hidden');
                }
            </script>
        @endif
    </div>
@endsection
