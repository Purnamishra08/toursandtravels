<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="{{ asset('assets/img/fav-icon.png') }}">
    <title>My Holiday Hapiness</title>
    <style>
        .page-header,
        .page-header-space {
            height: 130px;
        }

        .page-footer,
        .page-footer-space {
            height: 20px;

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
            background-color: #fff;
        }
.watermark{
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
}
.watermark img{
    opacity: .1;
    z-index: -1;
    height: 180px;
}
        @media print {
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
            .watermark {
    position: fixed;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    z-index: 0;
    opacity: 0.8;
    pointer-events: none;
}
.watermark img{
    opacity: .1;
    z-index: -1;
    height: 180px;
}
        }
    </style>
</head>

<body>
    <div class="page-header" style="text-align: center; -webkit-print-color-adjust:exact;
    print-color-adjust: exact;">
        <table style="width: 100%; border-collapse:collapse;color:#3c3c3c">
            <tr>
                <td style="padding: .25rem; text-align:center">
                    <img height="50" src="{{ asset('assets/img/web-img/logo.png') }}" alt="logo" />
                </td>
            </tr>
            <tr>
                <td style="padding: .25rem; ">
                    <h1 style="font-size:1.1rem; text-align:center;border-bottom:1px solid #3c3c3c;padding-bottom:1rem ">“2 Day Trip from Bhubaneshwar | Puri, Konark & Bhubaneshwar”</h1>
                </td>
            </tr>
        </table>


    </div>

    <div class="page-footer">
        <table style="width: 100%; border-collapse:collapse;color:#3c3c3c;color: #ff0000">
            <tr>
                <td>Support@myholidayhapiness.com</td>
                <td style="text-align: right; width:50%;padding-right:2rem">080 - 4120 9702 or +91 9886 52 52 53</td>
            </tr>
        </table>
    </div>
    <div class="watermark">
    <img height="50" src="{{ asset('assets/img/web-img/logo.png') }}" alt="logo" />
    </div>
    <div style="width:800px; margin:0 auto; font-size:.9rem; font-family: 'Times New Roman', serif; ">
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
                    <td style="padding: .25rem; ">Dear Sir/Madam,</td>
                </tr>
                <tr>
                    <td style="padding: .25rem; ">Please find requested “2 Day Trip from Bhubaneshwar | Puri, Konark & Bhubaneshwar”trip details.</td>
                </tr>
                <tr>
                    <td style="padding: .25rem; ">
                        <span style="padding: 3px 5px; background-color:yellow">No. of pax – 1 Adults, 1 Childrens</span>
                    </td>
                </tr>

                <tr>
                    <td>
                        <table style="width: 100%; border-collapse:collapse;margin-top:20px">
                            <tr>
                                <th style="border: 1px solid #c5dad6;padding: .25rem;background-color: #e0edeb;">Date</th>
                                <th style="border: 1px solid #c5dad6;padding: .25rem;background-color: #e0edeb;">Hotel</th>
                                <th style="border: 1px solid #c5dad6;padding: .25rem;background-color: #e0edeb;">Place</th>
                                <th style="border: 1px solid #c5dad6;padding: .25rem;background-color: #e0edeb;">No. of rooms</th>
                                <th style="border: 1px solid #c5dad6;padding: .25rem;background-color: #e0edeb;">Notes</th>
                                <th style="border: 1px solid #c5dad6;padding: .25rem;background-color: #e0edeb;">Vehicle</th>
                                <th style="border: 1px solid #c5dad6;padding: .25rem;background-color: #e0edeb;">Total Cost</th>

                            </tr>
                            <tr>
                                <td style="padding: .25rem; border:1px solid #c5dad6;text-align:center">22nd Apr</td>
                                <td style="padding: .25rem; border:1px solid #c5dad6;text-align:center">NRS Royal Palace</td>
                                <td style="padding: .25rem; border:1px solid #c5dad6;text-align:center">Puri </td>
                                <td style="padding: .25rem; border:1px solid #c5dad6;text-align:center">1 Deluxe Room</td>
                                <td style="padding: .25rem; border:1px solid #c5dad6;text-align:center">Breakfast</td>
                                <td style="padding: .25rem; border:1px solid #c5dad6;text-align:center">Sedan - AC (4+1)</td>
                                <td style="padding: .25rem; border:1px solid #c5dad6;text-align:center">Rs. 21,450</td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td>
                        <table style="width: 100%; border-collapse:collapse;margin-top:20px">
                            <tr>
                                <th style="border: 1px solid #c5dad6;padding: .25rem;background-color: #e0edeb; text-align:left">Day 1- Pick up at 8 AM - From Bhubaneswar Drive to Puri & Konark Sightseeing</th>
                            </tr>
                            <tr>
                                <td style="padding: .25rem; border:1px solid #c5dad6;">
                                    <ul style="padding-left: 1rem ; margin:0">
                                        <li> Puri Jagannath Temple</li>
                                        <li> Sudarshan Craft Museum</li>
                                        <li>Narendra Pushkarini</li>
                                        <li>Konark sun temple</li>
                                        <li>Konark beach</li>
                                        <li>Ramachandi temple</li>

                                    </ul>
                                </td>
                            </tr>
                            <tr>
                                <th style="border: 1px solid #c5dad6;padding: .25rem;background-color: #e0edeb; text-align:left">Day 2- Start at 8 AM from - Puri to Bhubaneswar, Bhubaneswar Sightseeing & drop</th>
                            </tr>
                            <tr>
                                <td style="padding: .25rem; border:1px solid #c5dad6;">
                                    <ul style="padding-left: 1rem ; margin:0">
                                        <li> Udaygiri & Khandagiri Caves </li>

                                        <li>Iskcon - Bhubaneswar</li>
                                        <li> Ram Mandir Bhubaneswar</li>
                                        <li>Odisha State Museum</li>
                                        <li> Nandan Kanan Zoo</li>
                                        <li> Lingaraj temple</li>

                                    </ul>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td>
                        <h5 style="font-size: 15px; border-bottom:1px solid #3c3c3c;display:inline-block;margin:20px 0 10px 0">Inclusions </h5>
                        <ul style="padding-left: 1rem ; margin:0">
                            <li>Selected private AC vehicle for pick up & drop and sightseeing</li>
                            <li>Selected category hotel for accommodation (not applicable for 1-day trips)</li>
                            <li>Home pick up and drop (Optional - Need to be communicated while booking)</li>
                            <li>Meal Plan for Hotel : Breakfast</li>
                            <li>Parking/Toll/ Driver Bata/ Fuel cost/Inter state taxes</li>


                        </ul>

                        <h5 style="font-size: 15px; border-bottom:1px solid #3c3c3c;display:inline-block;margin:20px 0 10px 0">Exclusions </h5>
                        <ul style="padding-left: 1rem ; margin:0">
                            <li>Early check in and late checkout charges will be applicable (depending upon hotel)
                                on Day 1 with additional cost.</li>
                            <li> Local Guide, Entrance fees, Jeep charges for mountain peaks & Safari charges</li>
                            <li>Meals other than mentioned (Lunch & Dinner) and any beverages. If dinner
                                required it will cost Rs. 650 per head per time.
                            </li>
                            <li>Items of personal nature viz. tips, laundry, travel insurance, camera fees, etc.</li>
                            <li>Cost of airfare/ train fare.</li>
                            <li>Hotel Gala dinner charges in the event of Christmas and New year eve.</li>
                            <li> Anything not specifically mentioned in the inclusion section.</li>
                            <li>Within 07 KM's (From our location - Rajajinagar 6th Block) complimentary home
                                pick up and drop services will be provided. Anything above than this will have extra
                                charges.</li>


                        </ul>
                        <h5 style="font-size: 15px; border-bottom:1px solid #3c3c3c;display:inline-block;margin:20px 0 10px 0">Cancellation Charges  </h5>
                        <ul style="padding-left: 1rem ; margin:0">
                            <li>16 day or more before the journey:25% deduction on package cost </li>
                            <li>14 day or more before the journey:50% deduction on package cost</li>
                            <li>7 to 14 days before the journey: 75% deduction on package cost</li>
                            <li>1 to 6 days before the journey: Non-refundable on package cost</li>


                        </ul>
                        <h5 style="font-size: 15px; border-bottom:1px solid #3c3c3c;display:inline-block;margin:20px 0 10px 0">Refunds
                        </h5>
                        <ul style="padding-left: 1rem ; margin:0">
                           <li>All refunds are processed with 7 working days</li>

                        </ul>
                        <h5 style="font-size: 15px; border-bottom:1px solid #3c3c3c;display:inline-block;margin:20px 0 10px 0">Bank Account
                        </h5>
                        <ul style="padding-left: 1rem ; margin:0">
                           <li>Bank name - Kotak Mahindra Bank</li>
                           <li>Account name - My Holiday Happiness</li>
                           <li>Account number - 9886 52 52 53</li>
                           <li>Account type - Current</li>
                           <li>IFSC Code - KKBK0008078 (Rajajinagar)</li>

                        </ul>
                        <h5 style="font-size: 15px; border-bottom:1px solid #3c3c3c;display:inline-block;margin:20px 0 10px 0">UPI (Google Pay/BHIM/UPI/PhonePe)
                        </h5>
                        <ul style="padding-left: 1rem ; margin:0">
                           <li>UPI ID - myholidayhappiness2018@ybl</li>
                           <li>PhonePe - 9886525253</li>
                           <li>Google Pay - 9886525253</li>
                           

                        </ul>
                    </td>
                </tr>
                <tr>
                    <td style="padding-top: 20px;">Please read our company reviews by clicking the link - <span style="color: #ff0000;">My Holiday Happiness reviews</span>
                    </td>
                </tr>
            </tbody>
            <tfoot>
                <tr>
                    <td>
                        <div class="page-footer-space"></div>
                    </td>
                </tr>
            </tfoot>
        </table>

    </div>

</body>

</html>