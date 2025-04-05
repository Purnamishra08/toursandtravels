@include('website.include.webmeta')
@include('website.include.webheader')

<div class="breadcrumb-section">
    <div class="container">
        <h1 class="page-name">Tour Details</h1>
        <ul class="breadcrumb-list">
            <li class="breadcrumb-item">
                <a href="#" class="breadcrumb-link"><i class="bi bi-house"></i></a>
            </li>
            <li class="breadcrumb-item">
                <a href="#" class="breadcrumb-link ">Tours</a>
            </li>
            <li class="breadcrumb-item">
                <a href="#" class="breadcrumb-link active">Tours Details</a>
            </li>
        </ul>
    </div>


</div>
<div class="page-area">
    <section class="contact-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 tour-details-box order-last order-lg-first">
                    <img class="destination-img" src="{{ asset('assets/img/web-img/blog-details.jpg') }}" alt="img" />
                    <h3 class="mt-2">Etiam placerat dictum consequat an Pellentesque habitant morbi.</h3>
                    <div class="d-flex align-items-center gap-2 mb-2">
                        <img src="{{ asset('assets/img/web-img/single-star.png') }}" alt="Rating">
                        <span class="text-secondary">8.0 Superb</span>
                    </div>
                    <div class="border-top tour-info">

                        <ul class="nav nav-pills mb-3 mt-3" id="pills-tab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="pills-home-tab" data-bs-toggle="pill" data-bs-target="#pills-home" type="button" role="tab" aria-controls="pills-home" aria-selected="true"><i class="bi bi-geo-alt ms-2"></i>Itinerary</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="pills-profile-tab" data-bs-toggle="pill" data-bs-target="#pills-profile" type="button" role="tab" aria-controls="pills-profile" aria-selected="false">Inclusions / Exclusions</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="pills-contact-tab" data-bs-toggle="pill" data-bs-target="#pills-contact" type="button" role="tab" aria-controls="pills-contact" aria-selected="false">Hotels</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="pills-disabled-tab" data-bs-toggle="pill" data-bs-target="#pills-disabled" type="button" role="tab" aria-controls="pills-disabled" aria-selected="false">Booking Policy</button>
                            </li>
                        </ul>
                        <div class="tab-content" id="pills-tabContent">
                            <div class="tab-pane no-scroll fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab" tabindex="0">
                                <ul class="timeline">
                                    <li>
                                        <div class="item">
                                            <div class="timelineheading">
                                                <span>Day-1</span>
                                                <strong>- Pick up at 8 AM - From Bhubaneswar Drive to Puri & Konark Sightseeing</strong>
                                                <ol>
                                                    <li>Puri Jagannath Temple</li>
                                                    <li>Sudarshan Craft Museum</li>
                                                    <li>Narendra Pushkarini</li>
                                                    <li>Konark sun temple</li>
                                                    <li>Konark beach</li>
                                                    <li>Ramachandi temple</li>
                                                </ol>

                                            </div>

                                        </div>
                                    </li>
                                    <li>
                                        <div class="item">
                                            <div class="timelineheading">
                                                <span>Day-2</span>
                                                <strong>- Start at 8 AM from - Puri to Bhubaneswar, Bhubaneswar Sightseeing & drop</strong>
                                                <ol>
                                                    <li>Udaygiri & Khandagiri Caves</li>
                                                    <li>Iskcon - Bhubaneswar</li>
                                                    <li>Ram Mandir Bhubaneswar</li>
                                                    <li>Odisha State Museum</li>
                                                    <li> Nandan Kanan Zoo</li>
                                                    <li>Lingaraj temple</li>
                                                </ol>

                                            </div>

                                        </div>
                                    </li>

                                </ul>
                            </div>
                            <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab" tabindex="0">
                                <strong>Inclusions</strong>
                                <ul class="itenary-ul mb-3">
                                    <li>Selected AC vehicle for pick up & drop and sightseeing</li>
                                    <li>Complimentary breakfast at selected hotel</li>
                                    <li>Selected category hotel for accommodation (not applicable for 1-day trips)</li>
                                    <li>All the sightseeing will be on a private basis in AC vehicle</li>
                                    <li>Entry tax, Toll, Parking charges, Driver allowance, Interstate tax if applicable</li>
                                    <li>Home pick up & drop - within 7 KM's (From our location - Rajajinagar 6th Block) complimentary home pick up and drop services will be provided. Anything above than this will have extra charges</li>
                                    <li>Total fares include GST</li>
                                </ul>
                                <strong>Exclusions</strong>
                                <ul class="itenary-ul mb-3">
                                    <li>Meals other than mentioned (Lunch & Dinner) and any beverages</li>
                                    <li>Local guide, Entrance fees to monuments, sight-seeing, parks and Sanctuaries and Safari charges</li>
                                    <li>Items of personal nature viz. tips, laundry, travel insurance, camera fees, etc.</li>
                                    <li>Early check-in or late checkout charges if applicable</li>
                                    <li>Hotel Gala dinner charges in the event of Christmas and New year eve</li>
                                    <li>Anything not specifically mentioned in the inclusion section</li>
                                </ul>
                                <strong>Optionals (arranged on request at additional cost)</strong>
                                <ul class="itenary-ul mb-3">
                                    <li>Any other choice of hotels/Resorts</li>
                                    <li>Local tour guide for selected destinations</li>
                                    <li>Honeymoon decoration - Flower bed decoration, Candlelight dinner, cake (Only at selected destinations) </li>
                                    <li>Visa and Travel insurance</li>

                                </ul>
                            </div>
                            <div class="tab-pane fade" id="pills-contact" role="tabpanel" aria-labelledby="pills-contact-tab" tabindex="0">
                                <strong class="mb-3 d-block">Puri (1N)</strong>
                                <div class="hotel-wrapper">
                                    <div class=" hotel-details-card">
                                        <div class="card-body">
                                            <a href="#"><i class="bi bi-buildings"></i> Hotel Swimming</a>
                                            <span class="d-block"> 
                                                <i class="bi bi-star-fill"></i>
                                                <i class="bi bi-star-fill"></i>
                                                <i class="bi bi-star-fill"></i>
                                               
                                            </span>
                                            <p>Three Star Hotel</p>
                                            <small class="d-block">(Deluxe room - Sea Facing)</small>
                                            <img src="{{ asset('assets/img/web-img/trip-adviser.png') }}" alt="img">
                                        </div>
                                    </div>
                                    <div class=" hotel-details-card">
                                        <div class="card-body">
                                            <a href="#"><i class="bi bi-buildings"></i> New Beach Resort</a>
                                            <span class="d-block"> 
                                                <i class="bi bi-star-fill"></i>
                                                <i class="bi bi-star-fill"></i>
                                                <i class="bi bi-star-fill"></i>
                                                <i class="bi bi-star-fill"></i>
                                               
                                            </span>
                                            <p>Four Star Hotel</p>
                                            <small class="d-block">(Executive Sea View room)</small>
                                            <img src="{{ asset('assets/img/web-img/trip-adviser.png') }}" alt="img">
                                        </div>
                                    </div>
                                    <div class=" hotel-details-card">
                                        <div class="card-body">
                                            <a href="#"><i class="bi bi-buildings"></i> Reba Beach Resort</a>
                                            <span class="d-block"> 
                                                <i class="bi bi-star-fill"></i>
                                                <i class="bi bi-star-fill"></i>
                                                <i class="bi bi-star-fill"></i>
                                                <i class="bi bi-star-fill"></i>
                                                <i class="bi bi-star-fill"></i>
                                               
                                            </span>
                                            <p>Five Star Hotel</p>
                                            <small class="d-block">(Deluxe Room)</small>
                                            <img src="{{ asset('assets/img/web-img/trip-adviser.png') }}" alt="img">
                                        </div>
                                    </div>
                                    <div class=" hotel-details-card">
                                        <div class="card-body">
                                            <a href="#"><i class="bi bi-buildings"></i> Hotel Swimming</a>
                                            <span class="d-block"> 
                                                <i class="bi bi-star-fill"></i>
                                                <i class="bi bi-star-fill"></i>
                                                <i class="bi bi-star-fill"></i>
                                               
                                            </span>
                                            <p>Three Star Hotel</p>
                                            <small class="d-block">(Deluxe room - Sea Facing)</small>
                                            <img src="{{ asset('assets/img/web-img/trip-adviser.png') }}" alt="img">
                                        </div>
                                    </div>
                                    <div class=" hotel-details-card">
                                        <div class="card-body">
                                            <a href="#"><i class="bi bi-buildings"></i> New Beach Resort</a>
                                            <span class="d-block"> 
                                                <i class="bi bi-star-fill"></i>
                                                <i class="bi bi-star-fill"></i>
                                                <i class="bi bi-star-fill"></i>
                                                <i class="bi bi-star-fill"></i>
                                               
                                            </span>
                                            <p>Four Star Hotel</p>
                                            <small class="d-block">(Executive Sea View room)</small>
                                            <img src="{{ asset('assets/img/web-img/trip-adviser.png') }}" alt="img">
                                        </div>
                                    </div>
                                    <div class=" hotel-details-card">
                                        <div class="card-body">
                                            <a href="#"><i class="bi bi-buildings"></i> Reba Beach Resort</a>
                                            <span class="d-block"> 
                                                <i class="bi bi-star-fill"></i>
                                                <i class="bi bi-star-fill"></i>
                                                <i class="bi bi-star-fill"></i>
                                                <i class="bi bi-star-fill"></i>
                                                <i class="bi bi-star-fill"></i>
                                               
                                            </span>
                                            <p>Five Star Hotel</p>
                                            <small class="d-block">(Deluxe Room)</small>
                                            <img src="{{ asset('assets/img/web-img/trip-adviser.png') }}" alt="img">    
                                        </div>
                                    </div>
                                    

                                </div>
                            </div>
                            <div class="tab-pane fade" id="pills-disabled" role="tabpanel" aria-labelledby="pills-disabled-tab" tabindex="0">
                                <strong>Booking Policy</strong>
                                <p>Regarding Modification Before the Travel Date</p>
                                <ul class="itenary-ul mb-3">
                                    <li>Must be applied for at least 3 days prior to the final travel date. Hotels will be provided depending upon availability</li>
                                    <li>Rs. 4000 will be charged as a service fee for a change of travel date (package cost less than 40,000 INR). Rs. 8000 will be chargeble if the package cost b/w 40 to 80K INR. Rs. 15000 will be chargeble if the package cost is more than 80K.</li>
                                    <li>The cancellation Policy will take hold if the requested modification doesn’t leave a margin of at least 3 days from the travel date</li>
                                    <li>The itinerary and vehicle are flexible for 3 days prior to the final travel date.</li>

                                </ul>
                                <strong>Regarding Hotel Bookings</strong>
                                <ul class="itenary-ul mb-3">
                                    <li>The tour package doesn’t include early check-in or late check-out charges.</li>
                                    <li>Standard hotel rooms will be on a twin-sharing basis.</li>
                                    <li>Extra bedding/mattress shall be provided for the third adult or child as per the booking.</li>
                                    <li>If not mentioned separately, basic rooms shall be provided.</li>
                                    <li>Standard hotel check-in time- 12-2:00 p.m.</li>
                                    <li>Standard hotel check-out time - 10:00 a.m-12 p.m.</li>
                                </ul>
                                <strong>Customer Responsibility</strong>
                                <ul class="itenary-ul mb-3">
                                    <li>Kindly be particular about sightseeing timings as places missed cannot be adjusted (or extended post 7:00 p.m.).</li>
                                    <li>Any extra distance covered for visiting places apart from the decided itinerary must be paid by you directly to the driver.</li>
                                    <li>To avoid any last moment inconveniences, let us know of your marital status beforehand (if you are an unmarried couple</li>
                                    <li>In case of any last minute inconvenience, inform us immediately. No issues would be addressed post the completion of the tou</li>
                                    <li>You must carry valid ID proofs for all the travellers concerned.</li>
                                    <li>Any change in the primary guest name shall lead to the cancellation of the tour along with the applicable cancellation charges.</li>

                                </ul>
                                <strong>Refund Policy</strong>
                                <ul class="itenary-ul mb-2">
                                    <li>Any/every refund shall take about 10 business days to get credited to the original payment method.</li>
                                    <li>100% refund in case of a cab strike.</li>
                                    <li>85% refund in case of natural calamities and any nature disturbances (Corona or any other transmitting deceases) reported 3 days before travel date.</li>
                                    <li>100% refund in the rare case of cancellation by My Holiday Happiness due to any unavoidable/extreme situation.</li>
                                    <li>100% refund in the rare case of last-minute hotel room unavailability (if the alternate hotel provided doesn’t satisfy you)</li>
                                    <li>No refunds for missed sightseeing places.</li>
                                    <li>Refund mode - Your refund will be credited to your original source of payment</li>
                                </ul>
                                <p class="text-danger mb-3">Note - All the refunds will be calculated on the total trip amount.</p>
                                <strong>Our Responsibility</strong>
                                <ul class="itenary-ul mb-3">
                                    <li>We do not take a guarantee for the unavailability of any site due to heavy rains or any temporary reason.</li>
                                    <li>We do not guarantee the familiarity of the driver with any specific language. We shall try our best to arrange one but it purely depends on the availability.</li>
                                    <li>Any concerned vouchers shall be delivered via e-mail within 24 hours of booking.</li>
                                    <li>If the hotel fails at providing the complimentary breakfast, we shall give INR 100, INR 150 or INR 250 for 2-star, 3-star or 4-star hotel respectively for the same.</li>
                                    <li>We shall provide all the details of the car and the driver 24 hours prior to the trip.</li>
                                    <li>In case of any delay by the cab, you may make up for that time at the end of the tour before your return flight.</li>
                                    <li>We shall provide alternate car or accommodation along with complimentary food in case of car breakdown for over 4 hours.</li>
                                </ul>
                                <strong>Cancellation Policy</strong>
                                <p>(The number of days excludes the travel date and all the refunds will be calculated on the total trip amount.)</p>
                                <ul class="itenary-ul mb-3">
                                    <li>Cancellation Fee post 16 days of booking- 25% of tour cost</li>
                                    <li>Cancellation Fee for cancellation done in 8-15 days from the travel date- 50% of tour cost</li>
                                    <li>Cancellation Fee for cancellation done in 3-7 days from the travel date- 75% of tour cost</li>
                                    <li>Sorry, no refund shall be made if you cancel in less than 2 days from the travel date.</li>
                                    <li>5% refund in case of natural calamities and any nature disturbances (Corona or any other transmitting deceases) reported 3 days before travel date.</li>
                                    <li>Partial cancellation - Rs. 1,000 will be refunded per person if there is any partial cancellation. A cancellation request should be submitted 3 days prior to the travel date.</li>

                                </ul>
                                <strong>Extra charges may apply</strong>
                                <ul class="itenary-ul mb-3">
                                    <li>For any pick-up/drop service apart from the ones mentioned in the itinerary.</li>
                                    <li>For an extra entry or activity fee.</li>
                                    <li>For any special event organized by the hotel (only if you wish to attend).</li>
                                    <li>Xmas and Year-end Gala dinner charges will be applicable if hotel is planning to have one.</li>
                                    <li>For breakfast only if you miss the complimentary hotel breakfast.</li>
                                    <li>Extra One day vehicle charges applicable if the drop timing crosses 12.00 AM midnight. For Sedan 3500, SUV 5000 and Tempo Rs. 6000</li>
                                    <li>Incase of vehicle breakdown new vehicle will be arranged within 4 hours of time</li>
                                </ul>
                            </div>
                        </div>
                    </div>


                    <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Quo quisquam similique et tenetur doloribus corrupti, eaque culpa molestias, a odit voluptate illum deleniti? Nesciunt ipsa sed dolorum inventore accusantium natus ad atque unde, obcaecati ducimus, eum reprehenderit modi error quidem aliquid veniam et ea delectus quo? Amet impedit dolore nihil voluptate quaerat facilis earum dignissimos ab, aliquam nemo deleniti eveniet, aut quidem maxime dolorum possimus doloribus voluptas deserunt consequuntur suscipit? Quisquam culpa odit possimus in, vero suscipit unde quam vitae deserunt, quia praesentium pariatur veritatis illum laudantium assumenda ea facilis dolorem consequuntur nesciunt maiores, animi iste? Quia pariatur delectus deserunt fuga voluptatibus quasi incidunt doloremque repudiandae, at veritatis qui hic quaerat dicta nostrum necessitatibus reprehenderit ab officiis. Pariatur, adipisci sequi nam libero sed molestiae iste totam quibusdam? Nam modi asperiores minima beatae itaque architecto, consequatur voluptas, cupiditate numquam tenetur, deleniti praesentium? Quis excepturi inventore facere nemo aut debitis ex laudantium exercitationem expedita illum? Aliquid veniam voluptas reiciendis ipsum consequuntur omnis saepe pariatur quia animi, eveniet asperiores, adipisci corrupti quaerat nobis? Molestias, laboriosam voluptatibus eos repellendus aliquam vitae nisi sed commodi sint quis iusto, explicabo id, dicta nemo eligendi quod architecto deleniti amet hic dignissimos cumque facere molestiae reprehenderit aliquid! In molestias deserunt mollitia quasi laborum inventore nulla quia fuga recusandae eius obcaecati dolore sint animi quisquam, veritatis culpa odio cupiditate voluptatum et unde exercitationem cum ad? Voluptas expedita sequi perferendis quisquam veritatis a officiis. Nostrum molestiae quos placeat ut quo quasi error quaerat repellat perspiciatis distinctio veritatis excepturi, ratione itaque fugit dignissimos ipsam perferendis dolores cupiditate rem, aut dolorem id modi impedit. Ipsam iste dicta sequi! Exercitationem cupiditate quod provident quos harum ipsa tempore corporis eaque laboriosam minima accusantium ducimus minus fugit perferendis molestias numquam sunt reiciendis ipsam, perspiciatis laudantium? Dolor, aliquid laboriosam delectus excepturi distinctio maxime at accusamus voluptas explicabo, perspiciatis quod minus. Ab officiis iste eum pariatur officia temporibus error fugiat dignissimos dolor aspernatur repellendus veniam laudantium itaque, eaque doloremque magni quis minus, cum facilis earum mollitia maxime saepe! Amet laudantium exercitationem obcaecati quidem, assumenda ut velit. Exercitationem distinctio enim mollitia sequi quas dolorem, ullam modi aspernatur omnis tempore eum quod, quia sapiente voluptates incidunt nobis itaque ducimus nihil quasi molestiae tempora explicabo maxime? Ipsam consequuntur modi vel similique, ad est architecto non suscipit eius explicabo. Cupiditate quas dignissimos, dolor voluptate nam tempora voluptatibus quia animi eius veritatis, sequi exercitationem inventore alias saepe. Ea, accusantium! Animi dicta, aliquam porro quisquam praesentium consequuntur ipsam sit vitae excepturi debitis nihil nam quis totam quidem ad impedit aut unde, commodi culpa enim accusamus? Dolorem suscipit laborum commodi. Velit reprehenderit vitae pariatur sit veritatis dolore quam adipisci ad similique error. Officiis esse maiores pariatur iusto consectetur saepe magnam sed quidem laudantium, perferendis ratione facilis. Totam natus vitae laudantium commodi odio nostrum tempora odit molestiae, quia ab! Fugit, vero temporibus. Sapiente, tempore labore culpa harum natus fuga ducimus sed nobis. Tempore est quod itaque ullam neque adipisci, at laudantium fugit autem sunt iure alias quia ipsam dolorum consectetur aliquam iste labore rem delectus ipsa nemo? Alias laborum adipisci officia tempore ea vero labore provident illum placeat, vitae natus quaerat, fugiat, dolorum optio quisquam neque ex eum consectetur aliquam assumenda! Quas, expedita aut inventore corrupti, dolorem natus possimus, iure accusamus eveniet rem laboriosam distinctio ipsam eius ipsa sit delectus cum numquam dolore tenetur libero culpa impedit? Nisi nam, quia delectus error sapiente dolorum autem mollitia amet accusamus obcaecati labore explicabo assumenda iste omnis quasi corrupti accusantium necessitatibus aliquam at iusto enim soluta voluptatem. Nam amet laudantium maiores, asperiores eligendi consequatur quia velit vel sint! Exercitationem aperiam dicta porro officiis dolore! Suscipit sapiente eveniet et ut soluta modi voluptates cum odit expedita quaerat excepturi natus aspernatur quibusdam veniam, ad ipsam in veritatis ipsum consectetur alias cupiditate numquam dolorem! Consectetur officiis totam voluptates commodi fugiat fuga beatae nesciunt nisi minima laborum ullam vero ipsa ducimus ut ad, aperiam nulla. Nihil quos distinctio fugit fuga iusto illo expedita quis quod dolorum. Vero ipsum voluptatem quod, laboriosam odit aut cupiditate adipisci, tenetur sunt accusantium laudantium explicabo! Itaque dolorum quia ullam, quas id atque aperiam suscipit quos voluptatum. Laudantium exercitationem labore amet nihil voluptate. Eaque consequatur consequuntur error, eveniet, doloribus hic, maiores atque ad officia nisi illum sapiente eius corporis maxime magni obcaecati qui ut? Quisquam veritatis recusandae dolor libero totam placeat perferendis maiores quae doloribus nostrum, deserunt voluptate facere error illo nisi laborum, adipisci eligendi dicta similique vero neque beatae molestias, aut quasi. Eum sint voluptas eos fugiat mollitia dolor tenetur, vel beatae ratione facilis libero? Adipisci doloribus eveniet aperiam sit recusandae necessitatibus facilis. In odit numquam debitis iste nostrum neque non ex eligendi natus unde delectus dolor omnis et eum repellendus officia nobis, nulla error nesciunt tempore fugiat commodi est pariatur molestias. Deleniti a nesciunt reprehenderit quos commodi cupiditate numquam aliquid tempore ipsum pariatur blanditiis, itaque, fuga dolores expedita totam sint facere. Accusamus est recusandae eligendi dolorum! Optio laboriosam accusamus ipsum magnam? Nisi reiciendis corrupti sapiente perferendis ipsum natus magnam accusantium sit debitis dolore quo, quasi, necessitatibus rerum illum sed nesciunt earum soluta, eaque alias optio. Laudantium officiis, rem animi quae aut labore, fugiat esse provident tenetur, molestiae voluptatibus cumque laborum ab veniam suscipit. Eveniet nam labore, repellat dolorem saepe vel distinctio? Reprehenderit, molestiae deserunt? Saepe fugit id aut voluptatem quasi sint quo totam! Assumenda illo adipisci aut laudantium veritatis reiciendis perspiciatis voluptatem nobis placeat velit optio molestias, accusantium odit rem? Dolorem iusto sequi voluptatem nemo, nobis consequatur optio! Libero adipisci eaque quos cum sint architecto ratione nulla commodi. Impedit, neque dolorum! Fuga amet dolores consequatur iure culpa qui! Dolore amet placeat, quo quos eius inventore numquam harum animi laborum fuga! Unde nam alias distinctio natus, quas nihil dignissimos illum at, aut repudiandae nemo consequatur atque ipsum ea. Nulla, iste, minus, dolores quo omnis nisi assumenda commodi esse numquam ex quam repellendus aliquid natus voluptates fugit pariatur? Placeat corporis itaque molestias magni architecto dicta distinctio sunt, facere incidunt! Quam facere labore architecto, eligendi obcaecati nesciunt. Impedit aperiam hic assumenda laudantium aliquid ipsum expedita ullam harum tempora reiciendis eligendi, similique sint veniam recusandae aliquam praesentium! Corrupti qui voluptates saepe? Expedita, corrupti. Illo sed neque quaerat minus nisi optio tempora qui repudiandae libero magni assumenda ullam, sequi, quia aperiam enim blanditiis eligendi laudantium possimus vero dicta. Perferendis totam modi voluptatem, aspernatur obcaecati, quod maxime repudiandae minima deserunt esse ex quasi culpa quam delectus et suscipit blanditiis eligendi fuga! Totam officia, autem inventore ab, fugit quos provident aut doloribus sint quam explicabo, aliquid amet eius ullam eum et libero suscipit architecto iste obcaecati. Facere distinctio temporibus ipsum vel, exercitationem voluptatum odio deserunt quasi, deleniti laudantium ipsa excepturi eveniet non sit voluptates, quod et officia officiis totam numquam perspiciatis esse. Quisquam voluptates quidem soluta deserunt inventore excepturi autem nihil sit vero adipisci architecto corporis facere maxime ipsa exercitationem explicabo, id perferendis, nostrum quas dolorum quam voluptatem amet pariatur. Maxime, animi eos magnam voluptatum suscipit quis officia corrupti et eum quidem similique adipisci nostrum repellat. Eos placeat quaerat cumque, veniam optio cupiditate at nulla facere nobis, officia accusamus pariatur. Voluptatibus quidem laboriosam ut, maiores laborum dolorum voluptates mollitia velit ex saepe eum dolores explicabo voluptatum unde fugit recusandae tempore earum? Assumenda autem repudiandae adipisci animi tempore laboriosam quia nobis itaque, enim officiis modi fugiat mollitia ipsam. Molestias est inventore ratione autem recusandae perspiciatis. Molestiae sint provident autem hic fugit praesentium, quia doloribus incidunt architecto ullam sunt necessitatibus fugiat cupiditate, ex laboriosam veritatis! Quae tenetur necessitatibus impedit nesciunt, omnis ab architecto animi cumque, ea odit quidem sunt! Consectetur minus suscipit deleniti ducimus? Ipsa modi quae nihil facere amet omnis delectus labore, aspernatur adipisci quasi molestias doloremque accusamus voluptate quia enim optio molestiae rem odio. Amet quasi quaerat quas illo doloribus, ad, explicabo molestias unde dolorem asperiores repellendus excepturi culpa consequuntur vitae delectus error. Repellendus, labore facilis voluptas alias dolores omnis dicta velit dolorem voluptatem dolor ex facere error odio vitae repellat neque fugit provident hic ad. Magni repellendus inventore similique rerum porro culpa eos velit libero eaque iure reprehenderit illo tempore amet deserunt hic odit delectus rem mollitia necessitatibus animi ipsum quis, veniam asperiores. Alias consequatur explicabo ipsam odio inventore accusantium, iusto eaque consequuntur, error, non necessitatibus ipsum eos voluptas obcaecati suscipit tenetur tempora porro quam quasi optio. Corporis quidem voluptatem error iste debitis, nam molestias nesciunt accusamus laudantium aliquam labore repellendus possimus quibusdam aut voluptate asperiores eum maxime modi quo ullam nobis qui laboriosam consequuntur rem! Consectetur similique blanditiis non cupiditate, unde maiores suscipit excepturi autem, soluta vel iure deserunt magni aliquid qui reprehenderit? Ad laborum, veritatis minima ipsa consequatur, quis, accusantium officiis iusto voluptate expedita voluptatum? Molestias omnis voluptates dignissimos hic aliquam ipsum ex unde dolorum placeat eum mollitia impedit, odit illo! Laudantium amet tenetur iusto possimus sapiente laborum quo fugit accusantium iure doloribus, nobis totam quas praesentium nesciunt illum quaerat. Dolorum aspernatur ipsa consequuntur mollitia! Deserunt aperiam asperiores inventore rem sed eligendi est totam, doloribus quibusdam, quos reprehenderit voluptas magnam exercitationem officiis debitis nam dolore! Officiis saepe facere totam praesentium, amet veritatis quod nulla voluptates enim sint impedit deserunt voluptatibus a eum repudiandae dolor et facilis labore vel ratione nostrum illo molestias magnam. Incidunt repellat officiis magni dignissimos aut tempora, commodi voluptas. Sint labore ipsa beatae alias quia numquam similique eveniet voluptate, perspiciatis eum. Officiis repudiandae quod voluptates cupiditate, expedita minus a at similique error, quia dolores minima tempore explicabo ipsum eligendi nisi nam? Vitae illum saepe ipsa officiis nulla aperiam quia explicabo voluptas dolor? Ipsum natus voluptate nobis, sed voluptatum hic accusamus optio. Adipisci nobis, ad amet facilis laborum earum fugit itaque. Assumenda fuga laborum sint enim nostrum libero iure temporibus fugit accusantium atque optio dignissimos voluptatibus asperiores natus porro esse neque veniam ipsum facilis officiis a praesentium, aliquid explicabo perspiciatis? Asperiores sunt soluta eum ducimus officiis. Voluptatum perspiciatis non cumque reprehenderit debitis possimus et dignissimos veritatis ipsam excepturi consectetur ullam iste ab ut eligendi, consequuntur explicabo. Repudiandae officia consectetur perspiciatis eum modi labore harum laborum eius porro facere corporis nam impedit eveniet fugiat at vero rerum beatae ut quaerat adipisci consequuntur quibusdam, ratione doloremque assumenda! Doloribus veniam mollitia et placeat eum eaque saepe harum quisquam esse perferendis ipsa, ratione itaque distinctio consequuntur dolores neque cum repellendus exercitationem magni? Blanditiis officiis quis a suscipit nihil cumque natus voluptatibus earum! Fuga similique mollitia consectetur deleniti atque. Assumenda dolor nisi iste eaque illum deleniti eveniet quidem vero tempore amet, placeat nihil dolore, tenetur, vitae deserunt. Odio fugit culpa consectetur, voluptates assumenda cumque quia cupiditate molestiae illum voluptas perferendis beatae, quis laudantium doloremque eligendi, saepe aliquid illo ab et debitis eveniet laboriosam optio accusamus. Dolore, fugit optio facilis fuga expedita accusamus, aliquid, inventore pariatur itaque officia est eaque voluptates reprehenderit distinctio. Totam aut dolorum esse ut at eos delectus dolorem assumenda ipsa cupiditate id adipisci tenetur suscipit fugiat unde possimus quae molestias dignissimos quibusdam accusamus, laudantium dolor nulla consequatur vel! Quaerat neque deleniti earum magni voluptates modi soluta. Ipsa impedit doloribus animi aspernatur repellendus est, incidunt distinctio laborum fuga? Vel veritatis alias vitae provident tempora, fuga minus quas explicabo laboriosam at, repellendus incidunt rerum sit est fugit fugiat, natus quae repudiandae? Maxime quibusdam sint exercitationem suscipit quaerat aliquam maiores eius vero autem, doloremque sapiente iure cupiditate laudantium perferendis error, veniam ratione vitae expedita eos asperiores magni excepturi quasi. Autem eligendi quasi assumenda quam sunt? Quidem quo recusandae reiciendis fugiat minima odio voluptates esse repellendus excepturi porro voluptatum quas sunt corrupti est dignissimos at laboriosam, facere eligendi, facilis vel. Dolore, non architecto! Natus eum assumenda ex, placeat quos debitis laboriosam doloremque exercitationem. Voluptate doloribus ducimus saepe quis fugit rem tempora quidem? Harum necessitatibus minima eum deserunt eveniet vero excepturi recusandae dolores. Nesciunt eveniet asperiores quasi modi sint earum corrupti quas necessitatibus placeat nisi esse, sapiente molestiae qui, reiciendis tenetur, magni culpa quos dignissimos officiis veritatis veniam voluptatibus ea alias. Quo, quam. Accusamus quia libero ipsum quidem sequi voluptatem corrupti minus adipisci corporis cum accusantium et recusandae molestias animi ratione rerum, quae sint. Earum facilis expedita consequatur totam incidunt optio amet nemo labore, animi repellat! Enim, exercitationem, voluptatum officia blanditiis alias voluptatibus quam ducimus possimus modi tenetur obcaecati magni quia. Quidem dolor, sequi accusamus amet illo atque necessitatibus quod! Recusandae dignissimos aperiam iste nobis amet. A in doloremque pariatur placeat, quibusdam repellendus perspiciatis ex numquam sit minima tenetur unde optio aperiam! Optio dolorem fugit beatae ipsum corrupti quaerat totam ea, sunt deleniti rerum? Rem, ullam, consequatur rerum numquam facilis saepe accusantium cum nisi, molestiae qui atque necessitatibus! Saepe vel expedita eum impedit pariatur perspiciatis facere ducimus consequuntur maiores quaerat exercitationem voluptatibus nobis porro repudiandae iste nesciunt molestias esse laudantium hic tenetur reprehenderit praesentium, repellendus dicta cumque! Ipsam sapiente, aliquam, eveniet totam, adipisci obcaecati molestiae quam nemo facilis corporis corrupti ducimus. Maxime, ipsam excepturi. Quisquam perferendis temporibus vero, repudiandae delectus repellendus voluptatum asperiores blanditiis! Saepe et soluta nesciunt repudiandae debitis, deserunt, error sequi cumque aliquam amet, a consequuntur facilis ducimus ea omnis nemo. Ex, et expedita. Neque quidem ad voluptas facere quasi, deleniti suscipit aut explicabo modi. Molestias, ullam. Aliquam aperiam ex animi rem, non ea maiores sunt similique fugit odio ducimus doloremque voluptatum error autem molestiae rerum ut quibusdam iure. Ea autem itaque laborum officia sint eos veniam quas temporibus omnis ipsum sapiente incidunt, cumque, magni delectus? Commodi ea expedita dolorem nihil voluptatem sint consequatur. Eveniet cumque, excepturi laboriosam eum vel ab laudantium, labore voluptates nostrum sunt repellendus quam distinctio et omnis odio expedita cum rem nisi voluptatem, amet incidunt maxime quisquam. Repellat delectus eius, exercitationem obcaecati nisi, ut odit eum fugiat deserunt voluptas sint dicta corporis numquam? Nulla ipsam sunt unde perferendis, magnam eos praesentium. Corporis quas amet doloremque vitae dolore sed, dolorum molestiae ipsam quidem velit suscipit ab tenetur blanditiis aspernatur? Dolor officia eveniet qui debitis perferendis numquam, quia dignissimos! Distinctio ipsum id aspernatur minima exercitationem. Cum vel reprehenderit ipsam excepturi suscipit. Dignissimos, quae modi officiis ipsam magnam eius similique iure eos ullam quasi, facilis autem vero iste ad! Libero iste, dicta eveniet eaque, molestias blanditiis fuga, sapiente voluptates laborum unde sequi iusto omnis laboriosam quaerat sed perspiciatis. Doloremque voluptates, reiciendis illum, saepe exercitationem, voluptas nulla voluptatibus deserunt error adipisci quibusdam dolorum? Commodi aliquid nobis veniam nam quos cumque! Ex cupiditate vero error voluptates id adipisci soluta voluptatum mollitia, labore nulla! Minus optio doloremque ipsum necessitatibus ducimus, blanditiis repellendus debitis iure omnis sit rem dolor voluptate unde consectetur molestiae nemo deserunt officiis eum tempora enim provident culpa! Veritatis, neque corrupti. Fugit voluptas, maxime ipsa libero amet exercitationem debitis est? Qui voluptate, amet natus impedit voluptatum, corporis vel nam esse, eum inventore totam voluptatem aperiam aliquam rem nisi! Id aliquam error molestias, veritatis, eius ratione cumque modi iste dolorem quae maxime beatae quia eum iusto commodi accusantium recusandae nemo, fugit ex dolore sint rerum placeat maiores! Assumenda, pariatur et illum rem sit numquam nisi libero sunt! Velit odio dolor soluta ullam cupiditate recusandae mollitia rerum delectus quis perferendis corrupti, beatae a debitis quidem assumenda eaque inventore, modi fugit optio voluptates! Nihil recusandae esse nesciunt eaque. Accusantium reprehenderit deserunt quam aspernatur magni dolorum iste reiciendis adipisci velit aliquam tempora obcaecati ut tempore error veniam, accusamus doloribus? Quam esse neque architecto assumenda tenetur nemo velit, veritatis dolorem nulla deserunt eum hic dolor quos vel maxime atque cum? Eum, quo neque dicta esse sunt voluptas corrupti quia soluta mollitia officiis explicabo modi aliquid voluptatum doloremque veniam? Voluptatibus quasi eos, nihil placeat ad aliquid neque ullam ducimus nobis nesciunt dolores porro quod reprehenderit reiciendis rerum mollitia odio molestias animi, omnis temporibus laborum, quis facere nemo. Laudantium ducimus fugit blanditiis tempora numquam, illo mollitia exercitationem a fugiat fuga, aut ipsa! Molestiae consectetur cum laboriosam, quidem mollitia dignissimos similique nesciunt illum hic vel atque minima esse temporibus ducimus consequatur architecto laudantium reprehenderit non quo, repellendus doloremque dicta fugit earum. Distinctio, optio mollitia est nisi, corrupti eius facere temporibus error commodi soluta atque illo. Eligendi placeat, aliquid id mollitia molestiae accusantium dicta optio minus sed animi maiores consectetur modi iure quam dignissimos quibusdam neque enim corrupti temporibus impedit? Sed labore dolores dolorum. Omnis perspiciatis asperiores sit magni aliquid nesciunt laudantium, culpa ipsum minus nihil error alias maxime sequi iste odit, eaque, dolorem temporibus? Rem omnis consequatur maxime iure rerum numquam architecto eveniet fugiat impedit praesentium dolores, optio voluptatum repellendus doloribus illum dignissimos nam! Ab quas dicta dolorum atque ipsam velit corporis voluptatem pariatur, quaerat ad eaque ducimus? Non saepe fugiat eum recusandae dicta officiis temporibus quis odit aspernatur ipsum cupiditate quod velit error exercitationem beatae, quasi commodi veritatis explicabo nihil incidunt eos sapiente possimus! Similique, magnam fugiat id minima quibusdam reiciendis quo nostrum explicabo. Voluptas, quos laudantium repellendus soluta sed excepturi consectetur voluptatum facilis tempore voluptatibus veritatis mollitia qui, saepe vel quis eius repudiandae iusto praesentium. Soluta eligendi distinctio illum voluptates aspernatur explicabo voluptas porro ipsam dolorum exercitationem doloribus excepturi, culpa eaque vero iusto? Vel possimus reiciendis iste earum officiis repudiandae quae libero, perspiciatis quaerat. Voluptatum quia molestias eos excepturi culpa ex quae ut libero, incidunt dolorum error doloremque tenetur vero distinctio dicta quaerat aut sint facilis! Asperiores nemo, harum quae maxime accusantium distinctio magni eius alias odio nobis quia. Excepturi laborum totam consequatur iste corporis expedita provident hic, corrupti eius nostrum? Adipisci iusto perspiciatis, blanditiis magni, ipsam aliquid cupiditate atque illo, voluptas eos sunt veritatis nobis sint. Labore quos neque accusamus ipsum recusandae voluptate ipsa! Iusto quis expedita quisquam cupiditate deserunt suscipit? Rem delectus praesentium est nulla neque laborum, beatae reprehenderit consequatur ex ipsa dolore totam labore cumque harum excepturi et ratione facere obcaecati? Deserunt consequatur temporibus fugit commodi rem quod inventore atque quos repellendus. Ab ullam voluptatem a ratione doloribus asperiores earum commodi, ipsum et, facere saepe neque voluptates blanditiis modi, praesentium temporibus vel ea nam odio expedita dolor fugiat quisquam? Incidunt exercitationem asperiores at ipsam laboriosam similique obcaecati ut, commodi consequuntur, labore tempore nemo aliquid amet ab tempora mollitia recusandae excepturi. Dolores, unde! Dolorem eaque consequuntur, esse architecto commodi, maiores saepe obcaecati, ad quae impedit odio. Laborum impedit voluptatem delectus autem molestiae tempore nesciunt eius tempora nihil soluta, similique sed unde, illum, repudiandae magni nostrum corporis? Corporis, accusamus veritatis. Quasi odit eligendi quibusdam iusto cum molestiae quis explicabo dolor odio, doloremque obcaecati distinctio eveniet adipisci officia nostrum aperiam alias quam earum sed dolores impedit. Deserunt illum delectus eos aspernatur sint eveniet, ex, est, autem praesentium ducimus tempore modi iure voluptas perspiciatis ipsa. Explicabo nisi eum error cupiditate excepturi voluptates laborum delectus, inventore neque atque debitis voluptate ut ipsa necessitatibus veritatis commodi? Enim eos quae explicabo nobis impedit voluptatem repellat, error labore. Asperiores iste voluptates magnam quaerat, sed reiciendis voluptatibus ratione alias quas natus animi perspiciatis odit sunt! Quas nam dolor libero deserunt molestiae dicta fuga voluptate veritatis commodi, dolores repellendus vitae nostrum possimus deleniti sed assumenda dignissimos mollitia. Enim deserunt vitae nemo fugiat eos voluptatum earum consequuntur laboriosam dolorum. Nesciunt dolores consequuntur ex pariatur modi aliquam similique, laboriosam dolorem facilis dolor rerum eaque quidem quos explicabo laudantium inventore suscipit obcaecati doloremque esse excepturi veritatis reprehenderit? Odit reprehenderit nobis fuga eaque aspernatur, expedita ipsum doloremque numquam consectetur ad enim praesentium, quo itaque officiis! Distinctio culpa numquam dolore placeat, dolores ad praesentium accusamus! Odit ratione, ipsam voluptate reprehenderit optio deleniti sint exercitationem voluptas explicabo rem aut sed! Qui praesentium debitis ullam deleniti aliquid quam similique quas corporis neque, ad tempora. Fugiat ex illum debitis impedit vel libero recusandae fugit voluptatum, veritatis aut eligendi voluptates sit voluptatibus, quam aspernatur quia voluptate? Cumque deserunt nesciunt odio expedita fugiat illo aspernatur. Nobis pariatur nihil quas ea aliquid optio soluta aut enim? Non libero, minima quasi sunt illum saepe culpa eum odio ipsam ipsum minus veniam dolore placeat eligendi vero maxime autem praesentium quae inventore ratione. Dolorem, sint quasi quod placeat provident impedit sit laudantium nemo esse veniam, recusandae, adipisci quo consequatur in voluptate necessitatibus? Accusantium sunt ratione nobis! Iure cumque voluptates dolores facere consequuntur vitae maiores earum delectus ex, quisquam pariatur quae eum harum doloremque deleniti dolorum. Ipsa animi earum laudantium, doloremque repellendus tempora autem ducimus minus repellat quos totam delectus temporibus, exercitationem aliquam doloribus! Odio, magnam maxime soluta provident nesciunt, eligendi cumque velit perspiciatis doloremque nihil voluptatem repellat commodi quia vel hic optio vitae ipsum aspernatur explicabo similique id esse libero! Ex soluta, dolorem sunt molestiae doloremque voluptatibus! At, perferendis numquam magnam accusantium sapiente praesentium incidunt sint consequatur recusandae, non, sequi nobis porro vel excepturi facilis culpa enim eum? Illum aperiam quibusdam sunt exercitationem eius eum repellendus reprehenderit assumenda. Alias ut ex iure obcaecati sit doloremque tempore quos facere dolorem illum consectetur, aut nesciunt voluptates aperiam ad culpa laboriosam expedita totam repellat illo vitae veritatis fugit voluptate. Aut aliquid inventore asperiores in quos recusandae ducimus cum optio doloremque facere obcaecati tenetur est, ipsam, eius corrupti vero, eos sed ipsum facilis blanditiis eum consequuntur vel? Suscipit sequi modi nisi minus. Quibusdam facere voluptatibus, voluptates numquam ducimus fugit provident doloribus aliquam maiores dolor distinctio porro. Id ipsum deserunt necessitatibus quo velit excepturi nemo deleniti nulla doloribus unde molestiae, porro quibusdam nihil non. Accusantium, blanditiis quam error adipisci possimus temporibus harum quis quae sequi tempora eligendi excepturi incidunt illo, praesentium fugit laborum alias consequuntur provident, cum ex sunt hic deserunt officiis atque. Natus non, minima quod vel aut nesciunt consectetur itaque maiores? Quam fugit voluptates harum impedit accusantium modi, ea voluptate facere facilis possimus minus odit itaque dolor natus pariatur adipisci corporis, ab explicabo maiores tempora. Nemo porro qui obcaecati vel voluptas consequuntur quo atque nesciunt illum aspernatur, eligendi numquam corrupti voluptatum esse fugiat unde quae blanditiis necessitatibus ipsa consectetur non accusantium id. Hic cumque quo veniam, dolore dolor magni rerum non praesentium quis ab maiores labore accusantium aperiam quasi minus ex voluptatum tenetur nihil. Sint cum molestias, magnam ad doloribus nulla temporibus deserunt, unde dignissimos eos quos ducimus possimus laborum similique fugit architecto totam deleniti quidem. Fugiat a ipsum tempore in eos, dolore commodi reiciendis ipsam accusamus, eum minima soluta! Exercitationem recusandae accusamus placeat animi. Ullam sed voluptate esse deleniti! Consequuntur fugit quae dolores quasi labore, voluptates reiciendis nobis ratione modi autem reprehenderit id excepturi. Odit repellat beatae architecto aliquid similique corrupti vitae dolor laborum facere quibusdam fugit dignissimos nesciunt, laudantium dolorum explicabo ratione laboriosam id sapiente necessitatibus perspiciatis repudiandae vel illo pariatur. Vero at itaque incidunt id eos, similique fugiat, aspernatur dolorum eum amet rem odit. Deleniti, eveniet. Voluptates voluptatibus nemo recusandae consequatur. Libero sunt a minus eveniet optio deleniti tenetur repellendus. Ullam hic, modi rem exercitationem cum consequuntur dicta eaque repellendus nemo, iste, dolores aperiam voluptate doloribus ex beatae! Aut consequatur enim, ad id ex magni error repellendus repudiandae nostrum assumenda, rem asperiores eum exercitationem esse odio? Assumenda et voluptatem minus suscipit, repellat fugit iste atque. Ut suscipit velit asperiores cumque ipsa neque voluptate ea accusamus, inventore nihil molestiae dolores illum consectetur nulla eum, nobis laudantium autem atque! Eius magnam delectus quaerat inventore nemo, commodi illo impedit facere dicta tenetur non ducimus laborum incidunt, eveniet ratione fugiat corporis error quam perferendis! Aliquam id ratione necessitatibus a aperiam quam natus quaerat voluptatem dignissimos modi omnis ducimus, quasi nesciunt qui magnam deleniti quisquam quia. Animi, aliquid. Reiciendis, corrupti ipsa? Eum provident quidem earum minima in reiciendis molestiae ipsa cupiditate expedita vel temporibus accusantium fugit itaque sequi aut, doloribus eos iusto omnis, officia odit nemo eligendi numquam et. Error eos, qui explicabo adipisci asperiores eum! Sunt asperiores odit, sed doloribus voluptate repellat ad ratione neque dolor alias nobis fugiat distinctio veritatis assumenda ducimus maiores debitis sapiente ipsa labore? Quae iste asperiores voluptatem consequatur modi ullam officia, libero harum repellat, temporibus aspernatur. Ducimus quam consectetur voluptatem laborum similique accusantium rerum dicta dolorum, minus quia sunt delectus architecto ad, earum, non placeat repudiandae itaque? Similique illum alias magni recusandae id vel accusantium inventore hic consectetur necessitatibus, non labore earum doloremque, voluptas blanditiis possimus eaque ex sunt voluptates commodi eos vero laborum? Ea voluptatum atque possimus quaerat nihil, cumque, laudantium asperiores ratione voluptas dolor repellat assumenda sequi. Expedita laborum atque provident porro beatae aliquam eum alias quaerat fugit impedit sed iure animi, id quae libero necessitatibus culpa voluptate nesciunt unde. Sint ea magni reprehenderit iusto maiores eveniet. Aliquid aliquam, ad commodi, magni animi a eligendi molestiae illum natus similique quis corrupti ipsum culpa deleniti iusto necessitatibus libero cupiditate accusamus nam. Nesciunt unde, fugiat, asperiores tempore in eligendi atque temporibus consequuntur quidem voluptate error amet quibusdam? Ratione veniam excepturi tenetur ad. Officia quasi nulla eum id nihil unde aspernatur quae sequi eaque reprehenderit itaque, nostrum quaerat saepe libero atque molestiae rem voluptate illo. Mollitia modi, itaque sapiente provident assumenda tempora numquam quo? Expedita, sit odit quod rem eius pariatur modi temporibus facere sunt aliquam id asperiores. Totam, minima dolor, quae modi atque esse fugit itaque expedita veritatis vel alias, tempora iusto. Fugit, deserunt quod eum autem aut mollitia? Mollitia ea cum sed sapiente doloribus perferendis veritatis temporibus fuga, maxime dignissimos deserunt natus itaque, similique aperiam iste quos sit laborum quisquam? Natus repudiandae deleniti laudantium dolore. Perferendis aliquam minima, dolor expedita, incidunt, eius nulla repudiandae temporibus veniam quas provident voluptatibus quaerat error corporis? Dolorem debitis iste doloremque alias, animi cum, quis ducimus odio voluptate asperiores dolorum minus consectetur vero ipsum dolor. Expedita iste voluptatum unde velit, pariatur explicabo, assumenda reiciendis sequi sed obcaecati temporibus optio praesentium impedit. Reiciendis doloribus illum saepe quo laboriosam pariatur nostrum itaque voluptates perspiciatis repellendus, sint maxime iusto esse fugit adipisci molestias alias nam omnis harum tempore, velit, similique optio error delectus? Ipsam consectetur cum fugiat, ut cumque voluptatibus at enim quia vel maxime tenetur repellat, architecto est ad. At itaque exercitationem illo nam, odit unde commodi ipsum voluptatum fugiat animi doloremque eaque quae quisquam incidunt, sapiente corporis. Eaque explicabo veniam et dignissimos ipsum vel dicta officiis fugit molestiae? Reiciendis quam repudiandae, accusamus ratione exercitationem facere similique sit a quasi, voluptates necessitatibus. Corporis reiciendis facilis voluptates obcaecati. Iusto dicta veritatis eligendi distinctio, consequuntur eos cum totam facilis quia fugiat nostrum voluptatum fuga vel labore. Nulla labore molestias fugit incidunt, culpa placeat dolorum assumenda aliquid doloremque ipsum quidem laborum nam cupiditate. Minima amet sapiente, consequuntur accusamus, tempora quaerat quasi fugiat nemo dolorum officia quas, fuga ea. Alias adipisci perferendis, illum, excepturi sunt aut rem iusto rerum, ipsam expedita officiis repellat corrupti facilis placeat quisquam sit earum deserunt culpa aperiam? Eveniet ut nam facilis architecto tempore pariatur blanditiis odit vel repellat, dolor id debitis totam nesciunt ipsam incidunt earum nobis sequi eius quisquam, atque repellendus nihil explicabo ea! Omnis quaerat, est sapiente repudiandae perspiciatis explicabo consectetur quam corporis voluptatibus eligendi optio expedita hic suscipit consequuntur similique rerum dolorum doloribus exercitationem voluptatum? Eaque earum et facere quam expedita ea maxime placeat quibusdam veritatis ab aspernatur cumque maiores totam, illo incidunt explicabo pariatur! Sed dolorum saepe fuga voluptas quae quo exercitationem delectus nemo, ad sint quidem, rem aliquam explicabo sapiente labore neque! Incidunt, quo. Accusantium ad saepe et, sint libero perferendis sed beatae pariatur provident, nam optio quo temporibus nostrum vero, error iste fuga neque? Atque, magni possimus fuga perferendis excepturi quis expedita at, quia deleniti provident incidunt eligendi dicta odio cumque. Sunt ipsam officiis repellat at hic. Earum id asperiores, nulla consequatur totam, odio adipisci molestiae et possimus eius optio perspiciatis expedita debitis aliquid doloremque iste temporibus eveniet libero vero! Reiciendis, ad necessitatibus sequi blanditiis nulla accusantium assumenda veritatis saepe quae quis? Ipsum ab cupiditate asperiores ipsa quasi officia iure accusantium deleniti aperiam cum sunt saepe veritatis nisi ducimus pariatur quibusdam molestias id nostrum est, dolorem aspernatur sed soluta porro! Laboriosam cumque sit eos sapiente magni ad illum voluptatem repudiandae corporis at mollitia accusantium vero fuga, corrupti fugit voluptates ea consectetur. Eveniet ratione est consequuntur veritatis voluptas quas cupiditate mollitia facilis officia dolor nostrum minus dolore, nam unde autem. Sunt sit deserunt iste quaerat explicabo magnam vel minima molestiae quod consequatur eum delectus cumque, maiores earum consectetur quasi esse, aut rerum, fuga accusantium cum! Laudantium, autem tempore unde hic deleniti voluptas dolorem quod harum impedit libero commodi eius saepe doloribus veniam similique, nostrum aliquam tenetur debitis eos aspernatur. Modi odio optio quisquam esse, explicabo excepturi facilis delectus eos perferendis incidunt autem dolorem consectetur aut, asperiores odit eligendi dolores! Cum, esse dolorum! Numquam corporis atque aliquam facere error! Accusamus sed a suscipit laborum enim dolore aut. Magni, odit excepturi, numquam explicabo tempore earum laborum nobis architecto voluptatibus quia nemo? Enim cupiditate ratione culpa ad eveniet labore fugiat est iste nemo, magnam animi officiis, dolorem dolores cumque id ducimus! Eaque blanditiis voluptatem iure. Veniam illum maxime perferendis cupiditate fugit, sapiente assumenda distinctio necessitatibus, itaque, molestiae possimus voluptate deleniti minus fuga molestias deserunt rem natus reprehenderit laborum commodi vitae harum quaerat voluptas! Quidem ad nisi consectetur facere soluta quod facilis eligendi dolorum modi pariatur maiores quas, neque inventore molestiae odit incidunt eveniet ea animi! Animi et nemo commodi laborum aut unde, quisquam sunt quam maiores illo, inventore deleniti quod omnis aspernatur dolores iusto, exercitationem incidunt dolorum maxime excepturi? Exercitationem tempora aspernatur iure, aliquam, dicta rem ipsum laborum cum natus eveniet deleniti quas. Consequatur atque corporis beatae et aliquid fugiat, numquam reiciendis in illum iste eius, ullam molestiae sapiente nobis? At, molestiae pariatur odio quaerat, mollitia ratione, dolorum facere eos velit cum aspernatur delectus. Vitae ullam repellat reiciendis incidunt eveniet cumque sint quod. Quibusdam nemo voluptatem repellendus facere ratione labore vel cumque explicabo minus natus deserunt quia similique sit beatae animi, dolores autem pariatur rerum, quam accusamus ipsa ex libero eveniet nulla. Adipisci ea quam libero maxime corporis facilis? Nobis voluptates cum harum, nisi assumenda iste sit officia ad dicta impedit fugiat necessitatibus eligendi itaque facere deserunt quas ipsam hic ea animi ducimus eius? Cumque nobis iste delectus perspiciatis vero consequatur! Voluptatem libero rem expedita? Reprehenderit id magni maiores voluptatem mollitia officia dolores, dolore tempore voluptatum eligendi. Soluta nemo est molestias labore mollitia, amet in ad doloribus optio ratione quos quam assumenda ut rem laudantium ex. Esse suscipit, reiciendis laboriosam pariatur sint dolore dicta quisquam aperiam fugiat. Provident incidunt libero non quod ut vero expedita pariatur iusto distinctio eaque? Reiciendis recusandae ad autem voluptate quidem sapiente nulla, modi ducimus suscipit iste odio dicta, expedita cupiditate voluptas delectus sint. Cupiditate cumque, ea perspiciatis error harum obcaecati dolores rerum soluta corporis quis! Minima earum velit qui suscipit alias, sunt quo amet, vitae atque similique rerum soluta saepe accusamus aperiam. Consequuntur quo natus animi! Est.</p>
                </div>
                <div class="col-lg-4 stickey-sectio order-first order-lg-last">
                    <div class="card calculate-card stickey-section ">
                        <div class="card-body">
                            <h4 class="mt-3">Calculate your Trip</h4>
                            <div class="row g-3 mt-3">
                                <div class="col-12 position-relative">
                                    <label for="guest" class="d-block">Guest</label>
                                    <input type="text" class="form-control form-select " id="guestInput" readonly value="0 Guests">
                                    <div class="guest-wrapper" id="guestWrapper" >
                                        <ul class="">
                                        <li >
                                                <div class="label-box">
                                                    <strong class="d-block">Adults</strong>
                                                    <small class="text-muted">12years and above</small>
                                                </div>
                                                <div class="data-box d-flex justify-content-between  gap-3 align-items-center">
                                                    <span class="minus">-</span>
                                                    <input type="text"class="form-control guest-count" value="0" readonly >
                                                    <span class="plus">+</span>

                                                </div>

                                            </li>
                                            <li >
                                                <div class="label-box">
                                                    <strong class="d-block">Children</strong>
                                                    <small class="text-muted">Children: 6-12 Yrs</small>
                                                </div>
                                                <div class="data-box d-flex justify-content-between  gap-3 align-items-center">
                                                    <span class="minus">-</span>
                                                    <input type="text"class="form-control guest-count" value="0" readonly >
                                                    <span class="plus">+</span>

                                                </div>

                                            </li>
                                        
                                        </ul>

                                    </div>
                                </div>
                                <!-- <div class="col-md-6">
                                    <label for="adult" class="d-block">Adult</label>
                                    <div class="input-group ">
                                        <span class="input-group-text" id=""><i class="bi bi-plus"></i></span>
                                        <input type="text" class="form-control" aria-label="Username">
                                        <span class="input-group-text" id=""><i class="bi bi-dash"></i></span>
                                    </div>
                                    <small class="text-danger">(Adults: 12+ Yrs)</small>
                                </div>
                                <div class="col-md-6">
                                    <label for="adult" class="d-block">Children</label>
                                    <div class="input-group ">
                                        <span class="input-group-text" id=""><i class="bi bi-plus"></i></span>
                                        <input type="text" class="form-control" aria-label="Username">
                                        <span class="input-group-text" id=""><i class="bi bi-dash"></i></span>
                                    </div>
                                    <small class="text-danger">(Children: 6-12 Yrs)</small>
                                </div> -->
                                <div class="col-12">
                                    <label for="vehicle" class="d-block">Vehicle</label>
                                    <select class="form-select" aria-label="Default select example">
                                        <option selected>-Select Vehicle-</option>
                                        <option value="1">Sedan - AC (4+1)</option>
                                        <option value="2">SUV - AC (7+1)</option>
                                        <option value="3">Tempo Traveller - AC (12+1)</option>
                                    </select>
                                </div>
                                <div class="col-12">
                                    <label for="dot" class="d-block">Date of travel</label>
                                    <div class="input-group ">

                                        <input type="text" class="form-control date">
                                        <span class="input-group-text" id=""><i class="bi bi-calendar2"></i></span>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <label for="dot" class="d-block">Accommodation</label>
                                    <select class="form-select" aria-label="Default select example">
                                        <option selected>-Select Accommodation-</option>
                                        <option value="1">Three Star</option>
                                        <option value="2">Four Star</option>
                                        <option value="3">Five Star</option>
                                    </select>
                                </div>
                                <div class="col-12">
                                    <label class="d-block">Airport pickup & drop</label>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" id="inlineCheckbox1" value="option1">
                                        <label class="form-check-label" for="inlineCheckbox1">Pickup</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" id="inlineCheckbox2" value="option2">
                                        <label class="form-check-label" for="inlineCheckbox2">Drop</label>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="d-flex gap-2 flex-wrap-wrap">
                                        <Button class="btn btn-success">Calculate</Button>
                                        <Button class="btn btn-outline-warning" data-bs-toggle="modal" data-bs-target="#exampleModal">Inquiry/Customize</Button>
                                    </div>
                                </div>
                            </div>


                        </div>

                    </div>


                </div>
            </div>






        </div>


    </section>

</div>
<div class="modal fade" tabindex="-1" id="exampleModal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Enquiry Now</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row g-3">
                <div class="col-md-6 position-relative">
                                    <label for="guest" class="d-block">Guest</label>
                                    <input type="text" class="form-control form-select " id="guestInput" readonly value="0 Guests">
                                    <div class="guest-wrapper" id="guestWrapper" >
                                        <ul class="">
                                        <li >
                                                <div class="label-box">
                                                    <strong class="d-block">Adults</strong>
                                                    <small class="text-muted">12years and above</small>
                                                </div>
                                                <div class="data-box d-flex justify-content-between  gap-3 align-items-center">
                                                    <span class="minus">-</span>
                                                    <input type="text"class="form-control guest-count" value="0" readonly >
                                                    <span class="plus">+</span>

                                                </div>

                                            </li>
                                            <li >
                                                <div class="label-box">
                                                    <strong class="d-block">Children</strong>
                                                    <small class="text-muted">Children: 6-12 Yrs</small>
                                                </div>
                                                <div class="data-box d-flex justify-content-between  gap-3 align-items-center">
                                                    <span class="minus">-</span>
                                                    <input type="text"class="form-control guest-count" value="0" readonly >
                                                    <span class="plus">+</span>

                                                </div>

                                            </li>
                                        
                                        </ul>

                                    </div>
                                </div>
                    <div class="col-md-6">
                        <label for="dot" class="d-block">Date of travel</label>
                        <div class="input-group ">

                            <input type="text" class="form-control date" aria-label="Username">
                            <span class="input-group-text" id=""><i class="bi bi-calendar2"></i></span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label for="dot" class="d-block">Accommodation</label>
                        <select class="form-select" aria-label="Default select example">
                            <option selected>-Select Accommodation-</option>
                            <option value="1">Three Star</option>
                            <option value="2">Four Star</option>
                            <option value="3">Five Star</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label for="dot" class="d-block">First Name</label>
                        <input type="text" class="form-control">
                    </div>
                    <div class="col-md-6">
                        <label for="dot" class="d-block">Last Name</label>
                        <input type="text" class="form-control">
                    </div>
                    <div class="col-md-6">
                        <label for="dot" class="d-block">Email</label>
                        <input type="email" class="form-control">
                    </div>
                    <div class="col-md-6">
                        <label for="dot" class="d-block">Mobile No.</label>
                        <input type="text" class="form-control">
                    </div>
                    <div class="col-12">
                        <div class="form-floating">
                            <textarea class="form-control" placeholder="Leave a comment here" id="floatingTextarea2" style="height: 100px"></textarea>
                            <label for="floatingTextarea2">Message</label>
                        </div>

                    </div>
                    <div class="col-12">
                        <button class="btn btn-primary ">Submit</button>
                        <button class="btn btn-danger ">Cancel</button>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
<script>
document.addEventListener('DOMContentLoaded', function () {
  const guestInput = document.getElementById('guestInput');
  const guestWrapper = document.getElementById('guestWrapper');
  const plusButtons = document.querySelectorAll('.plus');
  const minusButtons = document.querySelectorAll('.minus');

  // Toggle guest box
  guestInput.addEventListener('click', function (e) {
    e.stopPropagation();
    guestWrapper.style.display = guestWrapper.style.display === 'block' ? 'none' : 'block';
  });

  // Close when clicking outside
  document.addEventListener('click', function (e) {
    if (!guestWrapper.contains(e.target) && e.target !== guestInput) {
      guestWrapper.style.display = 'none';
    }
  });

  // Update guest count
  function updateGuestCount() {
    const guestInputs = document.querySelectorAll('.guest-count');
    let total = 0;
    guestInputs.forEach(input => {
      total += parseInt(input.value);
    });
    guestInput.value = `${total} Guest${total !== 1 ? 's' : ''}`;
  }

  // Add guest
  plusButtons.forEach(btn => {
    btn.addEventListener('click', function () {
      const input = this.previousElementSibling;
      input.value = parseInt(input.value) + 1;
      updateGuestCount();
    });
  });

  // Remove guest
  minusButtons.forEach(btn => {
    btn.addEventListener('click', function () {
      const input = this.nextElementSibling;
      let value = parseInt(input.value);
      if (value > 0) {
        input.value = value - 1;
        updateGuestCount();
      }
    });
  });
});
</script>
@include('website.include.webfooter')