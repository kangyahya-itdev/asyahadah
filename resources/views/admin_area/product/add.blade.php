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
                            Tambah Produk
                        </div>
                        <div class="row">
                            <form class="col s12" action="{{route('admin.product.store')}}" method='POST'>
                                @csrf
                                <input type="hidden" name="id" id="productId" value="{{ $product->id ?? '' }}">
                                <div class="row">
                                    <div class="input-field col s6">
                                        <input placeholder="Ex: 20 Kg" id="productName" name="productName" type="text" class="validate" value="{{ old('productName', $product->name ?? '') }}"  required>
                                        <label for="productName">Product Name</label>
                                    </div>
                                    <div class="input-field col s6">
                                        <input placeholder="Ex: 20 Kilo Gram" id="desc" name="desc" type="text" class="validate" value="{{ old('desc', $product->description ?? '') }}"  required>
                                        <label for="desc">Desc</label>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="input-field col s6">
                                        <input placeholder="Ex: 200000" name='price' id="price" type="number" class="validate" value="{{ old('price', $product->price ?? '') }}"  required>
                                        <label for="price">Price</label>
                                    </div>
                                    <div class="input-field col s6">
                                        <input placeholder='Ex: 100' name='stock' id="stock" type="number" class="validate"  value="{{ old('stock', $product->stock ?? '') }}"  required>
                                        <label for="stock">Stock</label>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="input-field col s6">
                                        <input placeholder="Ex: 0.02%" name='personalCommission' id="personalCommission" type="number" class="validate" min="0" max="100" step="0.01" value="{{ old('personalCommission', $product->commissionProducts->personal_commission ?? '') }}"  required>
                                        <label for="personalCommission">Buyer Commission</label>
                                        <span class="helper-text" data-error="Invalid input" data-success="Valid input">Input commission percentage (0-100)</span>
                                    </div>
                                    <div class="input-field col s6">
                                        <input placeholder='Ex: 0.01%' name='referralCommission' id="referralCommission" type="number" class="validate" min="0" max="100" step="0.01"  value="{{ old('referralCommission', $product->commissionProducts->referral_commission ?? '') }}"  required>
                                        <label for="referralCommission">Referral Commission</label>
                                        <span class="helper-text" data-error="Invalid input" data-success="Valid input">Input referral percentage (0-100)</span>
                                    </div>
                                </div>
                                <div class='row'>
                                    <div class='input-field col s1'>
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