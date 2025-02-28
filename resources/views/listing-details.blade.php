<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="{{asset('assets/admin/dist/img/favicon.png')}}?{{ time() }}" type="image/x-icon" />
    <title>Listing Details</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300..800;1,300..800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/css/bootstrap.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick.min.css" />
    <link rel="stylesheet" href="{{ URL::asset('assets/dist/css/custom.css') }}">
    <script src="{{ URL('assets/plugins/jquery/jquery.min.js')}}"></script>
    <style>
        .content-wrapper-app-icon {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 20px;
            flex-wrap: nowrap;
            padding: 20px;
            text-align: center;
        }
        .store-button {
            display: inline-block;
            text-align: center;
        }
        .store-button img {
            width: 100%;
            max-width: 250px;
            height: auto;
        }
        @media (max-width: 768px) {
            .content-wrapper-app-icon {
                flex-direction: row;
                justify-content: center;
            }
        }
    </style>
</head>
<body>
    <!-- <img src="{{asset('assets/dist/img/logo.png')}}?{{ time() }}"> -->
    <div class="listing-detail-main">
        <div class="header-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12 text-center">
                        <div class="logo-main">
                            <img src="{{asset('assets/dist/img/logo.png')}}?{{ time() }}">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="banner-slider">
            <div class="banner-wrapper">
                <div class="banner-img">
                    @if(isset($listing->main_image) && file_exists($listing->main_image))
                        <img src="{{ url($listing->main_image) }}" alt="Image">
                    @endif
                </div>
                <div class="banner-cnt">
                    <div class="container-fluid">
                        <div class="banner-inner-cnt">
                            <div class="btn-group">
                                <!-- <a href="javascript:void(0)" class="btn icon-btn"><i class="fa-solid fa-arrow-left"></i></a>
                                <a href="javascript:void(0)" class="btn icon-btn"><i class="fa-solid fa-share-nodes"></i></a> -->
                            </div>
                            <div class="banner-txt">
                                <h2>{{(isset($listing->company_name)) ? $listing->company_name : '-'}}</h2>
                                <p><i class="fa-solid fa-location-dot"></i>{{(isset($listing->address)) ? $listing->address : '-'}}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="banner-wrapper">
                <div class="banner-img">
                    @if(isset($listing->main_image) && file_exists($listing->main_image))
                        <img src="{{ url($listing->main_image) }}" alt="Image">
                    @endif
                </div>
                <div class="banner-cnt">
                    <div class="container-fluid">
                        <div class="banner-inner-cnt">
                            <div class="btn-group">
                                <!-- <a href="javascript:void(0)" class="btn icon-btn"><i class="fa-solid fa-arrow-left"></i></a>
                                <a href="javascript:void(0)" class="btn icon-btn"><i class="fa-solid fa-share-nodes"></i></a> -->
                            </div>
                            <div class="banner-txt">
                                <h2>{{(isset($listing->company_name)) ? $listing->company_name : '-'}}</h2>
                                <p><i class="fa-solid fa-location-dot"></i>{{(isset($listing->address)) ? $listing->address : '-'}}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="content-wrapper">
            <div class="container-fluid">
                <p>{{(isset($listing->description)) ? strip_tags($listing->description) : '-'}}</p>
                <ul class="contact-list">
                    <li class="contact-item">
                        <div class="contact-icon"><i class="fa-solid fa-location-dot"></i></div>
                        <div class="contact-txt">
                            <p class="txt-red">Location</p>
                            <p>{{(isset($listing->address)) ? $listing->address : '-'}}</p>
                        </div>
                        <!-- <div class="arrow-btn">
                            <a href="javascript:void(0)" class="btn icon-btn"><i class="fa-solid fa-arrow-right"></i></a>
                        </div> -->
                    </li>
                    <li class="contact-item">
                        <div class="contact-icon"><i class="fa-solid fa-phone"></i></div>
                        <div class="contact-txt">
                            <p class="txt-red">Contact Number</p>
                            <p>{{(isset($listing->telephone_number)) ? $listing->telephone_number : '-'}}</p>
                        </div>
                        <!-- <div class="arrow-btn">
                            <a href="javascript:void(0)" class="btn icon-btn"><i class="fa-solid fa-arrow-right"></i></a>
                        </div> -->
                    </li>
                    <li class="contact-item">
                        <div class="contact-icon"><i class="fa-solid fa-envelope"></i></div>
                        <div class="contact-txt">
                            <p class="txt-red">Email Address</p>
                            <p>{{(isset($listing->email)) ? $listing->email : '-'}}</p>
                        </div>
                        <!-- <div class="arrow-btn">
                            <a href="javascript:void(0)" class="btn icon-btn"><i class="fa-solid fa-arrow-right"></i></a>
                        </div> -->
                    </li>
                    <li class="contact-item">
                        <div class="contact-icon">
                            <svg width="19" height="19" viewBox="0 0 19 19" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M9.79395 18.9999C11.1987 18.8003 12.4302 17.3342 13.2051 15.1689C12.0849 14.918 10.9418 14.7834 9.79395 14.7673V18.9999Z" fill="#ffffff"/>
                                <path d="M12.0386 18.6556C12.1216 18.6316 12.2043 18.6074 12.2864 18.5808C12.3557 18.5585 12.424 18.5345 12.4922 18.5105C12.573 18.4826 12.6535 18.4539 12.7337 18.4235C12.802 18.3976 12.8696 18.37 12.9374 18.3424C13.0156 18.3095 13.0937 18.2768 13.171 18.244C13.2385 18.2143 13.3055 18.1832 13.3725 18.1519C13.4483 18.1162 13.5238 18.0798 13.5987 18.042C13.6644 18.0085 13.7299 17.9743 13.7957 17.9392C13.8693 17.8998 13.9424 17.8595 14.015 17.8182C14.0807 17.781 14.144 17.7436 14.208 17.7052C14.2792 17.6614 14.35 17.6176 14.4204 17.5739C14.4834 17.5338 14.5462 17.4931 14.6083 17.4511C14.6776 17.4044 14.7458 17.3559 14.8138 17.3073C14.8749 17.2635 14.9356 17.2199 14.9953 17.176C15.061 17.1253 15.1283 17.0729 15.1942 17.0204C15.2527 16.9737 15.3111 16.9274 15.3686 16.8794C15.4342 16.8249 15.497 16.7685 15.5607 16.7121C15.6165 16.6625 15.6726 16.6135 15.7271 16.5627C15.7897 16.5042 15.8508 16.4436 15.9119 16.3835C15.9648 16.3312 16.0183 16.2797 16.0701 16.2262C16.0797 16.2162 16.0889 16.2055 16.0988 16.1952C15.3827 15.8254 14.6285 15.5351 13.8492 15.3296C13.444 16.622 12.7227 17.7932 11.751 18.7367C11.7776 18.7298 11.8042 18.7242 11.8308 18.7173C11.901 18.6976 11.97 18.676 12.0386 18.6556Z" fill="#ffffff"/>
                                <path d="M18.6511 10.1616H14.7146C14.6997 11.6986 14.4767 13.2265 14.0518 14.7038C14.9184 14.9352 15.7547 15.2681 16.5434 15.6953C17.8383 14.1345 18.5796 12.1885 18.6511 10.1616Z" fill="#ffffff"/>
                                <path d="M9.79395 9.50498H14.0576C14.041 8.0223 13.8234 6.54876 13.4113 5.12445C12.224 5.39521 11.0115 5.5398 9.79396 5.55583L9.79395 9.50498Z" fill="#ffffff"/>
                                <path d="M9.79395 0.666626V4.89921C10.9418 4.88302 12.0849 4.74853 13.2051 4.49765C12.4302 2.33238 11.1987 0.866209 9.79395 0.666626Z" fill="#ffffff"/>
                                <path d="M9.79396 14.1108C11.0115 14.127 12.2241 14.2716 13.4113 14.5423C13.8234 13.118 14.041 11.6443 14.0576 10.1616H9.79395L9.79396 14.1108Z" fill="#ffffff"/>
                                <path d="M16.5434 3.97137C15.7547 4.3986 14.9184 4.73138 14.0518 4.96287C14.4767 6.4401 14.6997 7.96798 14.7146 9.50501H18.6511C18.5794 7.47826 17.8382 5.53229 16.5434 3.97137Z" fill="#ffffff"/>
                                <path d="M16.0999 3.47326C16.0903 3.46348 16.0812 3.4529 16.0717 3.4428C16.0198 3.38926 15.9659 3.33764 15.913 3.28554C15.8521 3.22542 15.7914 3.16467 15.7285 3.10631C15.6742 3.05566 15.6179 3.00773 15.5621 2.95723C15.4984 2.9008 15.4348 2.84389 15.3694 2.78939C15.3127 2.74146 15.2545 2.69561 15.1967 2.6496C15.131 2.59638 15.0637 2.54348 14.9961 2.49266C14.9367 2.44794 14.8766 2.40465 14.8162 2.36137C14.7476 2.312 14.6786 2.26278 14.6088 2.21581C14.5473 2.17445 14.485 2.13406 14.4226 2.09446C14.3516 2.04877 14.2808 2.00405 14.2085 1.96076C14.1451 1.92277 14.0812 1.88526 14.0171 1.84887C13.9436 1.80687 13.8701 1.76615 13.7958 1.7264C13.7301 1.69353 13.6646 1.65778 13.5988 1.62492C13.5233 1.58677 13.4472 1.55006 13.3691 1.51399C13.3034 1.48273 13.2367 1.45227 13.169 1.42261C13.0913 1.38815 13.0127 1.35705 12.9344 1.32419C12.8667 1.29661 12.7994 1.26936 12.7311 1.24339C12.6514 1.21293 12.5706 1.1844 12.4898 1.1565C12.4215 1.13246 12.3532 1.10857 12.284 1.08613C12.2019 1.05952 12.1198 1.03531 12.0355 1.01095C11.9672 0.990908 11.8986 0.970549 11.8295 0.952274C11.8031 0.94506 11.7762 0.939449 11.7495 0.932556C12.7213 1.87612 13.4424 3.04716 13.8478 4.33971C14.6278 4.1342 15.3832 3.84373 16.0999 3.47326Z" fill="#ffffff"/>
                                <path d="M0.280762 9.50501H4.21725C4.23216 7.96799 4.45515 6.44011 4.87996 4.96287C4.0135 4.73154 3.17718 4.39875 2.38848 3.97137C1.09352 5.53213 0.352259 7.47824 0.280762 9.50501Z" fill="#ffffff"/>
                                <path d="M9.13773 18.9999V14.7673C7.98993 14.7835 6.84679 14.918 5.72656 15.1689C6.50133 17.3342 7.73297 18.8004 9.13773 18.9999Z" fill="#ffffff"/>
                                <path d="M9.13772 10.1616H4.87402C4.89069 11.6443 5.10807 13.118 5.52038 14.5423C6.70762 14.2714 7.92002 14.1268 9.1377 14.1108L9.13772 10.1616Z" fill="#ffffff"/>
                                <path d="M9.13773 0.666626C7.73297 0.866208 6.50133 2.33237 5.72656 4.49764C6.84679 4.74868 7.98993 4.88317 9.13773 4.89921V0.666626Z" fill="#ffffff"/>
                                <path d="M9.1377 5.55583C7.92017 5.5398 6.70761 5.3952 5.52039 5.12445C5.10808 6.54877 4.8907 8.02231 4.87402 9.50498H9.13773L9.1377 5.55583Z" fill="#ffffff"/>
                                <path d="M7.17989 0.932251C7.15327 0.939144 7.12666 0.944755 7.10005 0.951648C7.03049 0.970243 6.96187 0.990923 6.89262 1.01096C6.81022 1.03501 6.72847 1.05921 6.64574 1.0855C6.57601 1.10811 6.5074 1.13215 6.43879 1.15604C6.35847 1.18441 6.278 1.21263 6.19849 1.24276C6.12988 1.26906 6.06223 1.29631 5.99426 1.3242C5.91619 1.35706 5.83796 1.38993 5.76085 1.42263C5.69321 1.45229 5.62636 1.48339 5.55935 1.51465C5.48352 1.55039 5.40802 1.58678 5.33315 1.62462C5.26743 1.65812 5.20171 1.69243 5.13614 1.72737C5.06256 1.76681 4.98962 1.80721 4.91716 1.84856C4.85143 1.88527 4.78683 1.92295 4.72351 1.96142C4.65218 2.00438 4.58164 2.04879 4.51142 2.09271C4.44826 2.13311 4.38558 2.17383 4.32354 2.21583C4.25429 2.26248 4.186 2.31105 4.11803 2.35962C4.05695 2.40339 3.9962 2.44699 3.9364 2.49107C3.86923 2.54157 3.80511 2.59415 3.73746 2.64657C3.67911 2.69322 3.62028 2.73955 3.56321 2.7878C3.49748 2.84199 3.43512 2.89809 3.3718 2.9542C3.31569 3.00422 3.25911 3.05279 3.20428 3.10457C3.14192 3.16276 3.08117 3.22319 3.02025 3.28315C2.96735 3.33541 2.91348 3.38703 2.86154 3.44073C2.85209 3.45067 2.84295 3.46157 2.83301 3.47167C3.54894 3.84166 4.30334 4.13197 5.0826 4.33749C5.48785 3.04573 6.20859 1.87534 7.17989 0.932251Z" fill="#ffffff"/>
                                <path d="M3.01867 16.381C3.07974 16.4411 3.1405 16.5018 3.20318 16.5604C3.25768 16.6108 3.31379 16.6588 3.36974 16.7093C3.43338 16.7659 3.49702 16.8226 3.56242 16.8771C3.61917 16.9247 3.67704 16.9708 3.73508 17.0169C3.8008 17.0701 3.86637 17.123 3.93594 17.1742C3.99509 17.2186 4.05521 17.2615 4.11532 17.3056C4.18394 17.3549 4.25319 17.4041 4.32308 17.4514C4.38448 17.4927 4.44684 17.5331 4.5092 17.5729C4.58021 17.6184 4.65107 17.6631 4.72337 17.7064C4.78668 17.7446 4.85065 17.7819 4.91477 17.8185C4.98819 17.8605 5.06178 17.9012 5.13599 17.9408C5.20156 17.9736 5.26729 18.0094 5.33302 18.0422C5.40852 18.0804 5.48466 18.1171 5.56273 18.1533C5.62846 18.1843 5.69514 18.2147 5.76279 18.2446C5.84055 18.279 5.91893 18.3101 5.99748 18.343C6.06513 18.3705 6.13246 18.3978 6.20075 18.4238C6.28043 18.4544 6.36122 18.4829 6.44202 18.5108C6.51031 18.5347 6.5786 18.5587 6.64785 18.5811C6.72992 18.6076 6.812 18.632 6.89632 18.6562C6.96461 18.6763 7.03323 18.6966 7.10216 18.715C7.12877 18.7223 7.1557 18.7278 7.18231 18.7348C6.21053 17.791 5.48947 16.62 5.08406 15.3275C4.3048 15.5331 3.5504 15.8234 2.83447 16.1936C2.84409 16.2034 2.85323 16.2139 2.86285 16.2241C2.91206 16.2773 2.96512 16.3289 3.01867 16.381Z" fill="#ffffff"/>
                                <path d="M2.38848 15.6952C3.17719 15.268 4.01351 14.9352 4.87996 14.7037C4.45515 13.2265 4.23216 11.6986 4.21725 10.1616H0.280762C0.352419 12.1883 1.09352 14.1343 2.38848 15.6952Z" fill="#ffffff"/>
                            </svg>
                        </div>
                        <div class="contact-txt">
                            <p class="txt-red">Website</p>
                            <p>{{(isset($listing->website_address)) ? $listing->website_address : '-'}}</p>
                        </div>
                        <!-- <div class="arrow-btn">
                            <a href="javascript:void(0)" class="btn icon-btn"><i class="fa-solid fa-arrow-right"></i></a>
                        </div> -->
                    </li>
                    <li class="contact-item">
                        <div class="contact-icon"><i class="fa-solid fa-clock"></i></div>
                        <div class="contact-txt">
                            <p class="txt-red">Open Hours</p>

                            @php
                                if(isset($listing->open_hours) && !empty($listing->open_hours)) {
                                    foreach(json_decode($listing->open_hours, true) as $key => $value){

                                        if(isset($value['close'])){
                                            echo '<p>'.ucwords(str_replace("_", " ", $key)).'<span>Close</span></p>';
                                        } else {
                                            echo '<p>'.ucwords(str_replace("_", " ", $key)).'<span>'.$value['from'].'-'.$value['to'].'</span></p>';
                                        }
                                    }
                                }
                            @endphp
                        </div>
                        <!-- <div class="arrow-btn">
                            <a href="javascript:void(0)" class="btn icon-btn"><i class="fa-solid fa-arrow-right"></i></a>
                        </div> -->
                    </li>
                </ul>
            </div>
        </div>
        <div class="content-wrapper-app-icon">
            <div class="store-button">
                <a href="https://play.google.com/store/apps/details?id=mytownonline.app">
                    <img src="https://mytownonline.app/wp-content/uploads/2025/02/google-768x231.png" alt="Get it on Google Play">
                </a>
            </div>
            <div class="store-button">
                <a href="https://apps.apple.com/us/app/my-harties/id6502344736">
                    <img src="https://mytownonline.app/wp-content/uploads/2025/02/apple-768x231.png" alt="Download on the App Store">
                </a>
            </div>
        </div>
        <!-- <div class="fix-pos-btn">
            <a href="javascript:void(0)"><i class="fa-brands fa-whatsapp"></i></a>
        </div> -->
    </div>

    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick.min.js"></script>
    <script>
        $('.banner-slider').slick({
            dots: false,
            nav: false,
            infinite: true,
            slidesToShow: 1,
            slidesToScroll: 1,
            autoplay: true,
            autoplaySpeed: 2000
        });
    </script>
</body>
<script type="text/javascript">    
$(function(){
    setTimeout(function(){ 
        window.location.href="mytownonline://mytownonline.app/categories-and-services-detail/<?php echo $listing->id;?>"; 
    }, 2000);    
});
</script>
</html>