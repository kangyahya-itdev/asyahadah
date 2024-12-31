@extends('layouts.admin')
@section('content')
<main>
    <div class="container">
        <div class="row">
            <!-- DASHBOARD -->
             <div class="col s12 l12 dashboard">
                <div class="card">
                    <div class="card-content">
                        <div class="card-title">
                            Tambah Commission Product
                        </div>
                        <div class="row">
                            <form class="col s12" action="{{route('admin.commissions.store')}}" method='POST'>
                                @csrf
                                <input type="hidden" name="id" id="commissionProductId" value="{{ $commission_product->id ?? '' }}">
                                <div class="row">
                                    <div class="input-field col s3">
                                        <select name='productID' id="productID" required>
                                        <option value="" disabled {{ old('productID', $commission_product->product_id ?? null) === null ? 'selected' : '' }}>Pilih Produk</option>
                                            @foreach($product as $prod)
                                            <option value="{{ $prod->id }}" {{ old('productID', $commission_product->product_id ?? null) == $prod->id ? 'selected' : '' }}>
                                                {{ $prod->name }}
                                            </option>
                                            @endforeach
                                        </select>
                                        <label for="productID">Product</label>
                                    </div>
                                    <div class="input-field col s3">
                                        <input placeholder="Ex: 0.02%" name='personalCommission' id="personalCommission" type="number" class="validate" min="0" max="100" step="0.01" value="{{ old('personalCommission', $commission_product->personal_commission ?? 0) }}"  required>
                                        <label for="personalCommission">Buyer Commission</label>
                                        <span class="helper-text" data-error="Invalid input" data-success="Valid input">Input commission percentage (0-100)</span>
                                    </div>
                                    <div class="input-field col s3">
                                        <input placeholder='Ex: 0.01%' name='referralCommission' id="referralCommission" type="number" class="validate" min="0" max="100" step="0.01"  value="{{ old('referralCommission', $commission_product->referral_commission ?? 0) }}"  required>
                                        <label for="referralCommission">Referral Commission</label>
                                        <span class="helper-text" data-error="Invalid input" data-success="Valid input">Input referral percentage (0-100)</span>
                                    </div>
                                    <div class='input-field col s3'>
                                        <button type='submit' class='btn' value='submit'>
                                            Save
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- END_DASHBOARD -->
        </div>
    </div>
  </main>
  @endsection

  @push('script')
  <script>
    $(document).ready(function(){
        $('select').formSelect();
    });
  </script>
  @endpush