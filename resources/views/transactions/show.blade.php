@extends('layouts.app')

@section('title', 'Detail Transaksi')
@section('header', 'Detail Transaksi')

@section('content')
    <livewire:transaction-detail :id="$id" />
@endsection
