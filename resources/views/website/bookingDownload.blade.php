<!DOCTYPE html>
<html lang="en">
<?php
$imagePath = public_path('assets/img/logo.png');
$image = public_path('assets/img/logo.png');
$favIcon = public_path('assets/img/fav-icon.webp'); ?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="{{ $favIcon }}">
    <title>Coorg Packages</title>
    <style>
       
        td, th {
  word-break: break-word;
  white-space: normal;
}
        .page-header,
        .page-header-space {
            height: 115px;
        }

        .page-footer,
        .page-footer-space {
            height: 23px;
        }

        .page-footer {
            position: fixed;
            bottom: 0;
            width: 100%;
            background-color: #e0edeb;
            padding: 0 .5rem;
        }

        .page-header {
            position: fixed;
            top: 0mm;
            width: 100%;

        }

        .watermark {
            position: fixed;
            top: 50%;
            left: 50%;
            width: 100%;
            text-align: center;
            transform: translate(-50%, -50%);
            opacity: 0.08;
            z-index: -1;
            pointer-events: none;
        }

        .watermark img {
            height: 180px;
        }

        @media print {
            td, th {
                word-break: break-word;
                white-space: normal;
            }
           

            thead {
                display: table-header-group;
            }

            tfoot {
                display: table-footer-group;
            }

            button {
                display: none;
            }

            body {
                margin: 0;
            }

            .page-footer {
            position: fixed;
            bottom: 0;
            width: 100%;
            background-color: #e0edeb;
            padding: 0 .5rem;
        }

        .page-header {
            position: fixed;
            top: 0mm;
            width: 100%;

        }

            .watermark {
                position: fixed;
                top: 50%;
                left: 50%;
                width: 100%;
                text-align: center;
                transform: translate(-50%, -50%);
                opacity: 0.08;
                z-index: -1;
                pointer-events: none;
            }

            .watermark img {
                height: 180px;
            }

            .no-page-break {
                page-break-before: avoid;
                page-break-after: avoid;
            }

            .page-header-space,
            .page-footer-space {
                height: 115px;
                /* Adjust this as necessary for header/footer spacing */
            }
         
        }
    </style>
</head>

<body>
        <div class="watermark">
            <img height="50" src="{{ $imagePath }}" alt="logo" />
        </div>
        <div class="page-header" style="text-align: center; -webkit-print-color-adjust:exact;
        print-color-adjust: exact; ">
            <table style="width: 100%; border-collapse:collapse;color:#3c3c3c">
                <tr>
                    <td style="margin: .25rem; text-align:right">
                        <img height="50" src="{{ $image }}" alt="logo" />
                    </td>
                </tr>
                <tr>
                    <td style="margin: .25rem; ">
                        <h1 style="font-size:1.2rem; text-align:center;padding:.5rem 0 ; background-color: #e0edeb; margin:.5rem 0 0 0">{{$tpackage_name}}</h1>
                    </td>
                </tr>
            </table>
        </div>
        <div class="page-footer">
            <table style="width: 100%; border-collapse:collapse;color:#3c3c3c;color: #ff0000">
                <tr>
                    <td >{{$parameters[27]->par_value}}</td>
                    <td style="text-align: right; width:50%;padding-right:2rem">{{$parameters[28]->par_value}}</td>
                </tr>
            </table>
        </div>
        
        <div style="margin:0 auto; font-size:.9rem; font-family: 'Times New Roman', serif; padding-bottom:30px;">
        <table style="width: 100%; border-collapse:collapse;color:#3c3c3c">
            <thead>
                <tr>
                    <td>
                        <div class="page-header-space"></div>
                    </td>
                </tr>
            </thead>
            <tbody>

                <tr>
                    <td>Dear Sir/Madam,</td>
                </tr>
                <tr>
                    <span style="padding: 1px;display:block; margin-top:.5rem;">Please find requested <span style="font-weight: bold">“{{$tpackage_name}}”</span> trip details.</span>
                </tr>
                <tr>
                    <td>
                        <span style="padding: 3px 5px;display:block; margin-top:.75rem; background-color:yellow">No. of pax – {{$adult}} Adults, {{$child}} Children</span>
                    </td>
                </tr>

                <tr>
                    <td>
                        <table style="width:100%; border-collapse:collapse;margin:20px 0 20px 0">
                            <tr>
                                <th style="border: 1px solid #c5dad6;padding: 3px;background-color: #e0edeb;width:60px">Date</th>
                                <th style="border: 1px solid #c5dad6;padding: 3px;background-color: #e0edeb;width:130px">Hotel</th>
                                <th style="border: 1px solid #c5dad6;padding: 3px;background-color: #e0edeb;width:80px">Place</th>
                                <th style="border: 1px solid #c5dad6;padding: 3px;background-color: #e0edeb;width:110px">No. of rooms</th>
                                <th style="border: 1px solid #c5dad6;padding: 3px;background-color: #e0edeb;width:55px">Notes</th>
                                <th style="border: 1px solid #c5dad6;padding: 3px;background-color: #e0edeb;width:90px">Vehicle</th>
                                <th style="border: 1px solid #c5dad6;padding: 3px;background-color: #e0edeb;width:90px">Total Cost</th>

                            </tr>
                            @php
                            $currentDate = $travel_date;
                            list($day, $month, $year) = explode('/', $currentDate);
                            $currentDate = "$year-$month-$day";
                            @endphp

                            @foreach($field_value as $index => $hotel_id)
                                @php
                                    $hotels = DB::table('tbl_hotel')->select('hotel_name','room_type','destination_name')->where('hotel_id', $hotel_id)->first();
                                    $destName = DB::table('tbl_destination')->select('destination_name')->where('destination_id', $hotels->destination_name)->first();
                                    $noof_nights = DB::table('tbl_package_accomodation')
                                        ->where('package_id', $hid_packageid)
                                        ->where('destination_id', $hotels->destination_name)
                                        ->where('bit_Deleted_Flag', 0)
                                        ->value('noof_days');

                                    $totalPersons = $adult + $child;
                                    $roomsNeeded = $totalPersons <= 3 ? 1 : ceil($totalPersons / 2);
                                @endphp

                                @for($n = 0; $n < $noof_nights; $n++)
                                    @php
                                        $checkInDate = date("dS M", strtotime("+{$n} days", strtotime($currentDate)));
                                    @endphp
                                    <tr>
                                        <td style="padding: 3px; border:1px solid #c5dad6;text-align:center">
                                            {{ $checkInDate }}
                                        </td>
                                        <td style="padding: 3px; border:1px solid #c5dad6;text-align:left">
                                            {{ $hotels->hotel_name }}
                                        </td>
                                        <td style="padding: 3px; border:1px solid #c5dad6;text-align:left">
                                            {{ $destName->destination_name }}
                                        </td>
                                        <td style="padding: 3px; border:1px solid #c5dad6;text-align:left">
                                            {{ $roomsNeeded }} {{ $hotels->room_type }}
                                        </td>
                                        <td style="padding: 3px; border:1px solid #c5dad6;text-align:center">
                                            Breakfast
                                        </td>
                                        @if ($index === 0 && $n === 0)
                                            <td rowspan="{{ array_sum(array_map(function($hid) use($hid_packageid) {
                                                return DB::table('tbl_package_accomodation')
                                                    ->where('package_id', $hid_packageid)
                                                    ->where('destination_id', DB::table('tbl_hotel')->where('hotel_id', $hid)->value('destination_name'))
                                                    ->where('bit_Deleted_Flag', 0)
                                                    ->value('noof_days');
                                            }, $field_value)) }}" style="padding: 3px; border:1px solid #c5dad6;text-align:center">
                                                {{ $vehicle }}
                                            </td>
                                            <td rowspan="{{ array_sum(array_map(function($hid) use($hid_packageid) {
                                                return DB::table('tbl_package_accomodation')
                                                    ->where('package_id', $hid_packageid)
                                                    ->where('destination_id', DB::table('tbl_hotel')->where('hotel_id', $hid)->value('destination_name'))
                                                    ->where('bit_Deleted_Flag', 0)
                                                    ->value('noof_days');
                                            }, $field_value)) }}" style="padding: 3px; border:1px solid #c5dad6;text-align:center">
                                                Rs. {{ $total_price }}
                                            </td>
                                        @endif
                                    </tr>
                                @endfor

                                @php
                                    // Move the base date forward after finishing this hotel
                                    $currentDate = date("Y-m-d", strtotime("+{$noof_nights} days", strtotime($currentDate)));
                                @endphp
                            @endforeach

                        </table>
                    </td>
                </tr>
                @php
                    $noOfItineraries = DB::table('tbl_itinerary_daywise')
                            ->where('bit_Deleted_Flag', 0)
                            ->where('package_id', $hid_packageid)
                            ->count();
                    $daywiseItineraries = DB::table('tbl_itinerary_daywise')
                            ->where('package_id', $hid_packageid)
                            ->where('bit_Deleted_Flag', 0)
                            ->orderBy('itinerary_daywiseid')
                            ->get();
                    $day = 1;
                @endphp
                @if($noOfItineraries>0)
                @foreach($daywiseItineraries as $itinerary)
                @php $placeIds = $itinerary->place_id; @endphp
                <tr>
                    <td style="padding: 0;">
                        <table style="width: 100%; border-collapse:collapse;margin-bottom:0">
                            <tr>
                                <th style="border: 1px solid #c5dad6;padding: .25rem;background-color: #e0edeb; text-align:left">Day {{$day}}- {{$itinerary->title}}</th>
                            </tr>
                            <tr>
                                <td style="padding: .25rem; border:1px solid #c5dad6;">
                                    <ul style="padding-left: 1rem ; margin:0">
                                            @php 
                                                $places = DB::table('tbl_places')
                                                    ->select('placeid', 'destination_id', 'place_name', 'place_url')
                                                    ->whereIn('placeid', explode(',', $placeIds))
                                                    ->get();
                                                $otherPlaces = explode(',', $itinerary->other_iternary_places);
                                            @endphp
                                    
                                            @foreach($places as $place)
                                                <li> {{$place->place_name}}</li>
                                            @endforeach
                                    
                                            @if(!empty($itinerary->other_iternary_places))
                                                @foreach($otherPlaces as $otherPlace)
                                                    @if(!empty(trim($otherPlace)))
                                                        <li> {{$otherPlace}}</li>
                                                    @endif
                                                @endforeach
                                            @endif
                                    </ul>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                @php $day++; @endphp
                @endforeach
                @endif
            <!-- Include the page-break-before here to avoid page breaking within the inclusions -->
            <tr>
                <td >

                    <h5 style="font-size: 15px; border-bottom:1px solid #3c3c3c;display:inline-block;margin:20px 0 10px 0">Inclusions </h5>
                    {!! $parameters[25]->par_value !!}



                </td>
            </tr>
            <tr>
                <td>
                    <h5 style="font-size: 15px; border-bottom:1px solid #3c3c3c;display:inline-block;margin:20px 0 10px 0">Exclusions </h5>
                    {!! $parameters[26]->par_value !!}


                </td>
            </tr>
            <tr>
                <td>
                    <h5 style="font-size: 15px; border-bottom:1px solid #3c3c3c;display:inline-block;margin:20px 0 10px 0">Cancellation Charges </h5>
                    {!! $parameters[29]->par_value !!}

                </td>
            </tr>
            <tr>
                <td>
                    <h5 style="font-size: 15px; border-bottom:1px solid #3c3c3c;display:inline-block;margin:20px 0 10px 0">Refunds </h5>
                    {!! $parameters[30]->par_value !!}


                </td>
            </tr>
            <tr>
                <td>
                    <h5 style="font-size: 15px; border-bottom:1px solid #3c3c3c;display:inline-block;margin:20px 0 10px 0">Bank Account </h5>
                    {!! $parameters[31]->par_value !!}


                </td>
            </tr>
            <tr>
                <td>
                    <h5 style="font-size: 15px; border-bottom:1px solid #3c3c3c;display:inline-block;margin:20px 0 10px 0">UPI (Google Pay/BHIM/UPI/PhonePe) </h5>
                    {!! $parameters[32]->par_value !!}
                </td>
            </tr>
        </tbody>
        <tfoot>
            <tr>
                <td>
                    <div class="table-footer-space">

                    </div>
                </td>
            </tr>
        </tfoot>
        </table>
    </div>
</body>

</html>