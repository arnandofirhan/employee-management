@extends('errors::layouts.app')

@section('title', __('Page Expired'))
@section('code', '419')
@section('message', __($exception->getMessage() ?? 'Page Expired'))
@section('lightImage', asset('assets/images/errors/travel-2.png'))
@section('darkImage', asset('assets/images/errors/travel-2-dark.png'))
