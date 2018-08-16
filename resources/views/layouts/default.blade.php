
<!doctype html>
<html lang="{{app()->getLocale()}}">
<head>
    @include('includes.head')
</head>
<body>
<div id="container">
    <header class="header">
        @include('includes.header')
    </header>

   <div class="main">
    <!-- sidebar content -->
        <div class="sidebar">
            @include('includes.sidebar')
        </div>

        <!-- main content -->
        <div class="content">
            @include('includes.content')
        </div>

    </div>

    <footer class="footer">
        @include('includes.footer')
    </footer>

</div>
</body>
</html>

