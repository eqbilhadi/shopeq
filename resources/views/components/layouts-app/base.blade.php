<x-layouts-app.app {{ $attributes }}>
        <!-- Begin page -->
        <div id="layout-wrapper">

            <x-layouts-app.navbar />
    
            
            <!-- ========== App Menu ========== -->
            <x-layouts-app.aside />
            <!-- Left Sidebar End -->
            
            <!-- Vertical Overlay-->
            <div class="vertical-overlay"></div>
    
            <!-- ============================================================== -->
            <!-- Start right Content here -->
            <!-- ============================================================== -->
            <div class="main-content">
    
                <div class="page-content">
                    {{ $slot }}
                    <!-- container-fluid -->
                </div>
                <!-- End Page-content -->
    
                <x-layouts-app.footer />
            </div>
            <!-- end main content-->
    
        </div>
        <!-- END layout-wrapper -->
    
    
    
        <!--start back-to-top-->
        <button onclick="topFunction()" class="btn btn-danger btn-icon" id="back-to-top">
            <i class="ri-arrow-up-line"></i>
        </button>
        <!--end back-to-top-->
</x-layouts-app.app>