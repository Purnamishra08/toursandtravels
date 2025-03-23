<!-- Metaheader Section-->
@include('admin.include.metaheader')
<!-- Metaheader Section End -->
@php
use Carbon\Carbon;
@endphp

<body>
    <div id="layoutSidenav">
        <!-- Left Navbar Start-->
        @include('admin.include.leftNavbar')
        <!-- Left Navbar End-->

        <div id="layoutSidenav_content">
            <div class="content-body">

                <!-- TopBar header Start-->
                @include('admin.include.topBarHeader')
                <!--TopBar header end -->

                <!-- Main Content Start-->
                <main>
                    <div class="inner-layout">
                        <div class="container-fluid px-4 pt-3">
                            <nav class="tab-menu">
                                <!-- <a href="{{ route('admin.manageHotels.addHotel') }}" class="tab-menu__item">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-plus" viewBox="0 0 16 16">
                                        <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z"></path>
                                        </svg>
                                    Add
                                </a> -->
                                <a href="{{ route('admin.manageenquiry') }}" class="tab-menu__item">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                        class="bi bi-arrow-left" viewBox="0 0 16 16">
                                        <path fill-rule="evenodd"
                                            d="M15 8a.5.5 0 0 1-.5.5H3.707l4.147 4.146a.5.5 0 0 1-.708.708l-5-5a.5.5 0 0 1 0-.708l5-5a.5.5 0 0 1 .708.708L3.707 7.5H14.5a.5.5 0 0 1 .5.5z" />
                                    </svg>
                                    Back
                                </a>
                            </nav>
                            @include('admin.include.sweetaleart')
                            <section class="content">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="panel panel-bd lobidrag">
                                            <div class="panel-body">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="gap row">
                                                            <div class="col-md-4"> <label>Name</label></div>
                                                            <div class="col-md-8">{{$enquirys->cont_name}}</div>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6">
                                                        <div class="gap row">
                                                            <div class="col-md-4"> <label> Email Id </label></div>
                                                            <div class="col-md-8">{{$enquirys->cont_email}} </div>
                                                        </div>
                                                    </div>

                                                    <div class="clearfix"></div>
                                                    <div class="col-md-6">
                                                        <div class="gap row">
                                                            <div class="col-md-4"> <label> Phone no</label></div>
                                                            <div class="col-md-8">{{$enquirys->cont_phone}}</div>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6">
                                                        <div class="gap row">
                                                            <div class="col-md-4"> <label> Enquiry Date </label></div>
                                                            <div class="col-md-8">
                                                                {{\Carbon\Carbon::parse($enquirys->cont_date)->format('jS
                                                                M Y')}}</div>
                                                        </div>
                                                    </div>
                                                    <div class="clearfix"></div>
                                                    <div class="col-md-12">
                                                        <div class="gap row">
                                                            <div class="col-md-2"> <label> Page Name</label></div>
                                                            <div class="col-md-10">{{$enquirys->page_name}}</div>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-12">
                                                        <div class="gap row">
                                                            <div class="col-md-2"> <label> Enquiry Details </label>
                                                            </div>
                                                            <div class="col-md-10">{{$enquirys->cont_enquiry_details}}
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="clearfix"></div>
                                                    <hr>
                                                    <form
                                                        action="{{ route('admin.manageenquiry.viewEnquiry', ['id' => $enquirys->enq_id]) }}"
                                                        method="POST">
                                                        @csrf
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <label>Send Reply</label>
                                                                <textarea class="form-control" rows="10" name="reply"
                                                                    id="reply"
                                                                    style="margin: 0px 617px 0px 0px; width: 474px; height: 211px;"></textarea>
                                                                <input type="hidden" name="hdnenquiry_id"
                                                                    value="{{$enquirys->enq_id}}">
                                                            </div>

                                                        </div>
                                                        <div class="clearfix"></div>
                                                        <div class="col-md-6">
                                                            <div class="reset-button">
                                                                <button class="btn btn-dark" type="submit"
                                                                    name="btnReply" id="btnReply">Reply</button>

                                                            </div>
                                                        </div>
                                                    </form>



                                                    <div style="margin-top: 5px;">
                                                        <hr>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            @if($messages)
                                                            <label class="col-md-12">Messages has been already sent:</label>
                                                            @foreach($messages as $msg)
                                                            <div class="col-md-10 msgsection"><span
                                                                    class="messagedate">{{\Carbon\Carbon::parse($msg->created_date)->format('jS
                                                                M Y')}} :</span> {{$msg->message}}
                                                            </div>
                                                            @endforeach
                                                            @else
                                                            <div class="col-md-10 msgsection"> "No messages sent yet"
                                                            </div>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </section>
                        </div>
                    </div>
                </main>

                <!-- Footer Start-->
                @include('admin.include.footer')
                <!-- Footer End-->
            </div>
        </div>
    </div>
    <!-- FooterJs Start-->
    @include('admin.include.footerJs')
    <!-- FooterJs End-->
    
</body>

</html>