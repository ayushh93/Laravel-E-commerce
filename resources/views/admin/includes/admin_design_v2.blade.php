<!DOCTYPE html>
<html lang="en">
@include('admin.includes.head')
    <body>
		<!-- Main Wrapper -->
        <div class="main-wrapper">

@include('admin.includes.header')

@include('admin.includes.sidebar_v2')

@yield ('content')


@include('admin.includes.script')


