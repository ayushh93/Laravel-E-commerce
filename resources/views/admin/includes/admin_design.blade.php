<!DOCTYPE html>
<html lang="en">
@include('admin.includes.head')
    <body>
		<!-- Main Wrapper -->
        <div class="main-wrapper">

@include('admin.includes.header')

@include('admin.includes.sidebar')

@yield ('content')	
			
			
@include('admin.includes.script')

		
	