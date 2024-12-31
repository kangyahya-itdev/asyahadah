@extends('layouts.users')

@section('content')
<!-- Balance Section -->
<div class="container">
    <div class="row">
        <div class="col s12 m6">
            <div class="card light-green lighten-1">
                <form
                    action="{{ isset($user->rekenings) ? route('user_area.profile.update_rekening', $user->rekenings->id) : route('user_area.profile.store_rekening') }}"
                    method="POST"
                >
                @csrf
                @if(isset($user->rekenings))
                    @method('PUT')
                @endif
                    <div class="card-content white-text">
                        <span class="card-title">{{ isset($user->rekenings) ? 'Edit Rekening' : 'Tambah Rekening' }}</span>
                        <hr>
                        <div class="row">
                            <div class="input-field m6">
                                <i class="material-icons prefix">account_balance</i>
                                <select name="rekening_bank" id="rekening_bank" searchable='Pilih Bank atau E-Wallet'>
                                    <option value="">Pilih Bank / E-Wallet</option>
                                    <optgroup label="Bank">
                                    @foreach ($banks as $bank)
                                        <option value="{{ $bank['name'] }}" {{ old('rekening_bank', $user->rekenings->rekening_bank ?? '') == $bank['name'] ? 'selected' : '' }}>
                                            {{ $bank['name'] }}
                                        </option>
                                    @endforeach
                                    </optgroup>
                                    <optgroup label="E-Wallet">
                                        <option value="Ovo" {{old('rekening_bank', $user->rekenings->rekening_bank ?? '') == 'Ovo' ? 'selected' : ''}}>Ovo</option>
                                        <option value="Dana"  {{old('rekening_bank', $user->rekenings->rekening_bank ?? '') == 'Dana' ? 'selected' : ''}}>Dana</option>
                                    </optgroup>
                                </select>
                                <label for="rekening_bank">Rekening Bank</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="input-field m6">
                                <i class="material-icons prefix">123</i>
                                <input 
                                type="text" 
                                id="rekening_no" 
                                name="rekening_no" 
                                value="{{ old('rekening_no', $user->rekenings->rekening_no ?? '') }}" 
                                placeholder="Masukkan Nomor Rekening"
                                required
                            >
                            @error('rekening_no')
                                <span class="red-text">{{ $message }}</span>
                            @enderror
                                <label for="rekening_no">Rekening Bank</label>
                            </div>
                        </div>
                    </div>
                    <div class="card-action">
                    <div class="center">
                            <button type="submit" class="btn waves-effect waves-light {{ isset($user->rekenings) ? 'blue' : 'green' }}">
                                {{ isset($user->rekenings) ? 'Update Rekening' : 'Tambah Rekening' }}
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('script')
<script>
    $(document).ready(function(){
    $('select').formSelect();
  });
    document.addEventListener('DOMContentLoaded', function() {
        @if(session('success'))
            M.toast({html: '{{ session('success') }}', classes: 'green'});
        @endif
    });
</script>
@endpush
