<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    {{-- logo styles --}}
    <style>
        @page {
            header: page-header;
        }

        /* body {
            font-family: 'istok_web';
        } */

        .fl {
            float: left !important;
        }

        .ff-primary {
            font-family: 'istok_web' !important;

        }

        .ff-arabic {
            font-family: sans-serif !important;
        }

        .ff-secondry {
            font-family: 'island_moments' !important;
        }

        .pt-2 {
            padding-top: 2rem;
        }

        .w-full {
            width: 100%;
        }

        .w-half {
            width: 50%;
        }

        .w-one-third {
            width: 30%;
        }

        .w-quarter {
            width: 25%;
        }

        .w-5 {
            width: 5rem;
        }

        .w-6 {
            width: 6rem;
        }

        .w-7 {
            width: 7rem;
        }

        .w-9 {
            width: 9rem;
        }

        .w-10 {
            width: 10rem;
        }

        .w-11 {
            width: 11rem;
        }

        .w-12 {
            width: 12rem;
        }

        .w-13 {
            width: 13rem;
        }

        .w-14 {
            width: 14rem;
        }

        .w-15 {
            width: 15rem;
        }

        .fs-20 {
            font-size: 20px !important;
        }

        .fs-0-7 {
            font-size: 0.7rem !important;
        }

        .fw-400 {
            font-weight: 400 !important;
        }

        .fw-bold {
            font-weight: bold;
        }

        .mt-0-5 {
            margin-top: 0.5rem;
        }

        .mt-1 {
            margin-top: 1rem;
        }

        .mt-1-5 {
            margin-top: 1.5rem;
        }

        .mt-2 {
            margin-top: 2rem;
        }

        .mt-2-5 {
            margin-top: 2.5rem;
        }

        .mt-3 {
            margin-top: 3rem;
        }

        .mt-3-5 {
            margin-top: 3.5rem;
        }

        .mt-4 {
            margin-top: 4rem;
        }

        .primary-color {
            color: #373636 !important;
        }

        .invoice-world {
            color: #373636;
            font-weight: 700;
            padding-top: -15px;
        }

        .invoice-number {
            padding-top: 10px !important;
            color: #373636;
        }

        .invoice-date {
            padding-top: 10px !important;
            color: #373636;
        }
    </style>
    {{-- end logo styles --}}


    {{-- buyer information styles --}}
    <style>
        .line {
            height: 1px;
            background-color: #373636 !important;
            margin-top: 1rem;
            width: 20rem;
        }

        table,
        td,
        th {
            border: 0.5px solid #373636;
            text-align: center;
            border-collapse: collapse !important;
        }

        td {
            font-weight: 400;
            color: #373636 !important;
        }

        th {
            font-size: 20px;
            color: #373636;
        }

        table,
        th {
            border-top: 0px !important;
        }
    </style>
    {{-- end buyer information styles --}}


    {{-- seller styles --}}
    <style>
        .sellers {}

        .invoice-details {
            padding-top: 1rem;
        }
    </style>
    {{-- end seller styles --}}
</head>

<body>
    <htmlpageheader name="page-header">
        {{-- Logo --}}
        <div class="invoice-details">
            <div class="logo" style="width: 100%;float:left;">
                <div class="svg fl" style="width: 4.5rem">
                    <svg width="53" height="37" viewBox="0 0 53 37" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <g clip-path="url(#clip0_1744_1711)">
                            <path
                                d="M41.136 21.4482H40.0195V7.92231V0H32.9131V7.92231V21.4482V28.5547H40.0195H41.136H48.2639V21.4482V14.5779H41.136V21.4482Z"
                                fill="#6CB2AD" />
                            <path d="M31.8184 8.22266H24.6904V28.5544H31.8184V8.22266Z" fill="#6CB2AD" />
                            <path d="M48.2637 6.35498H41.1357V13.4829H48.2637V6.35498Z" fill="#C6C6C6" />
                            <path d="M31.8184 0H24.6904V7.12794H31.8184V0Z" fill="#C6C6C6" />
                            <path d="M23.5732 21.4268H16.4453V28.5547H23.5732V21.4268Z" fill="#C6C6C6" />
                            <path d="M23.5732 29.6494H16.4453V36.7773H23.5732V29.6494Z" fill="#C6C6C6" />
                            <path d="M23.5732 8.24414H16.4453V20.3101H23.5732V8.24414Z" fill="#6CB2AD" />
                            <path
                                d="M8.22289 7.92231V21.4482H7.12794V14.5779H0V21.4482V28.5547H7.12794H8.22289H15.3508V21.4482V7.92231V0H8.22289V7.92231Z"
                                fill="#6CB2AD" />
                            <path
                                d="M30.1005 30.5513C30.122 30.5513 30.1435 30.5727 30.1435 30.5942V35.4034C30.1435 35.7254 30.0146 35.8972 29.7355 35.9616C29.6926 35.9616 29.6497 35.9831 29.5852 35.9831C29.4779 35.9831 29.3705 35.9401 29.2632 35.8757C29.1559 35.8113 29.07 35.7254 28.9841 35.6181L27.2021 33.0417L26.7298 32.2474L26.7512 33.6644V35.8543C26.7512 35.8757 26.7512 35.8972 26.7298 35.8972H25.7422C25.7207 35.8972 25.7207 35.8757 25.7207 35.8543V31.1309C25.7207 30.9592 25.7636 30.8304 25.8281 30.723C25.9139 30.6157 26.0213 30.5513 26.1716 30.5298L26.5795 30.5727C26.6439 30.5942 26.7083 30.6371 26.7512 30.6586C26.7942 30.7015 26.8371 30.7445 26.8801 30.7874L28.6191 33.2994L29.0914 34.0938L29.07 32.6768V30.6157C29.07 30.5942 29.07 30.5727 29.0914 30.5727L30.1005 30.5513Z"
                                fill="#C6C6C6" />
                            <path
                                d="M32.2897 31.0021C32.3971 30.6586 32.6332 30.4868 32.9768 30.4868C33.3203 30.4868 33.5564 30.6586 33.6853 31.0021L35.5746 35.8328C35.5746 35.8542 35.5746 35.8542 35.5531 35.8542H34.4796C34.4367 35.8542 34.4152 35.8328 34.3938 35.8113L33.9858 34.7163H31.9462L31.5383 35.8113C31.5168 35.8328 31.4953 35.8542 31.4739 35.8542H30.4219C30.4004 35.8542 30.4004 35.8542 30.4004 35.8328L32.2897 31.0021ZM32.6547 32.505L32.2253 33.7931H33.7282L33.2988 32.5479C33.2559 32.4191 33.1914 32.2903 33.1485 32.1615C33.1056 32.0326 33.0626 31.9038 33.0412 31.7535H32.8909L32.6547 32.505Z"
                                fill="#C6C6C6" />
                            <path
                                d="M39.9766 30.9377C39.9981 30.9807 39.9981 31.0236 39.9981 31.0451C39.9981 31.088 39.9981 31.1095 39.9981 31.1524C39.9981 31.3456 39.9122 31.5389 39.7404 31.7321L37.6579 34.1796L36.9709 34.8452H38.1517H39.9981C40.0196 34.8452 40.0195 34.8452 40.0195 34.8667V35.8113C40.0195 35.8328 40.0196 35.8543 39.9981 35.8543H36.3697C36.0691 35.8543 35.8759 35.7255 35.79 35.4678C35.7686 35.4249 35.7686 35.4034 35.7686 35.3605C35.7686 35.3175 35.7686 35.2961 35.7686 35.2531C35.7686 35.1673 35.79 35.0599 35.833 34.974C35.8759 34.8667 35.9403 34.7808 36.0262 34.6734L38.1302 32.2259L38.8387 31.5389L37.6364 31.5603H35.9618C35.9403 31.5603 35.9403 31.5603 35.9403 31.5389V30.5942C35.9403 30.5727 35.9403 30.5513 35.9618 30.5513H39.4184C39.6975 30.5513 39.8907 30.6801 39.9766 30.9377Z"
                                fill="#C6C6C6" />
                            <path
                                d="M40.7061 30.5942C40.7061 30.5727 40.7275 30.5513 40.749 30.5513H41.7581C41.7795 30.5513 41.801 30.5727 41.801 30.5942V35.8328C41.801 35.8543 41.7795 35.8758 41.7581 35.8758H40.749C40.7275 35.8758 40.7061 35.8543 40.7061 35.8328V30.5942Z"
                                fill="#C6C6C6" />
                            <path
                                d="M46.7822 30.5513C46.7822 30.5727 46.7822 30.5727 46.7822 30.5513C46.7822 30.5727 46.7822 30.5727 46.7822 30.5727L45.2364 32.3762C45.5584 32.9344 45.902 33.5141 46.224 34.0938C46.5675 34.6734 46.8896 35.2531 47.2116 35.8113C47.2116 35.8328 47.2116 35.8328 47.2116 35.8543H46.0952C46.0093 35.8543 45.9664 35.8328 45.9449 35.8113L44.4635 33.2564L43.5403 34.3085V35.8328C43.5403 35.8543 43.5188 35.8757 43.4974 35.8757H42.5098C42.4883 35.8757 42.4883 35.8543 42.4883 35.8328V30.5942C42.4883 30.5727 42.4883 30.5513 42.5098 30.5513H43.5188C43.5403 30.5513 43.5618 30.5727 43.5618 30.5942L43.5403 32.9773L45.5155 30.6157C45.537 30.5727 45.5799 30.5513 45.6443 30.5513H46.7822ZM46.8037 30.5298C46.8037 30.5298 46.8037 30.5513 46.7822 30.5513C46.7822 30.5513 46.7822 30.5513 46.8037 30.5513C46.8037 30.5513 46.8037 30.5513 46.8252 30.5513C46.8037 30.5298 46.8037 30.5298 46.8037 30.5298Z"
                                fill="#C6C6C6" />
                            <path d="M3.49956 9.91899L6.99912 6.41943H0V13.4186H6.99912L3.49956 9.91899Z"
                                fill="#C6C6C6" />
                            <path
                                d="M52.2361 16.3812C52.2361 17.2615 51.5491 17.97 50.6473 17.97C49.7456 17.97 49.0586 17.283 49.0586 16.3812C49.0586 15.4795 49.7456 14.7925 50.6473 14.7925C51.5491 14.7925 52.2361 15.4795 52.2361 16.3812ZM49.3162 16.3812C49.3162 17.1327 49.8959 17.7338 50.6473 17.7338C51.4203 17.7338 51.9785 17.1327 51.9785 16.3812C51.9785 15.6298 51.3988 15.0286 50.6473 15.0286C49.8959 15.0072 49.3162 15.6083 49.3162 16.3812ZM50.3038 17.283H50.0677V15.458H50.7762C51.1841 15.458 51.3773 15.6298 51.3773 15.9733C51.3773 16.2954 51.1626 16.4456 50.9265 16.4886L51.4632 17.3044H51.2056L50.6903 16.4886H50.3038V17.283ZM50.6044 16.2739C50.8835 16.2739 51.1626 16.2739 51.1626 15.9518C51.1626 15.6942 50.9479 15.6298 50.7332 15.6298H50.3253V16.2739H50.6044Z"
                                fill="#B2B2B2" />
                        </g>
                        <defs>
                            <clipPath id="clip0_1744_1711">
                                <rect width="52.2357" height="36.7561" fill="white" />
                            </clipPath>
                        </defs>
                    </svg>
                </div>
                <div class="fl invoice-world ff-primary" style="width: 20rem;">
                    <h1 style="font-size: 1.5rem;">Invoice</h1>
                </div>
                <div class="invoice-number fl ff-primary" style="width: 14rem;">
                    Invoice no. {{ $order->order_number }}
                </div>
                <div class="invoice-date ff-primary" style="width: 100px;">
                    {{ $order->created_at->format('Y-m-d') }}
                </div>
            </div>
        </div>
        {{-- Logo --}}
    </htmlpageheader>


    {{-- Buery Info --}}
    <div class="primary-color">
        <div class="fw-400 fs-20 ff-primary">
            <span style="font-family: istok_web !important">Buyer information</span>
        </div>
        @if ($order->user->fullName !== ' ' && $order->user->fullName)
            <div class="fw-bold mt-1-5 ff-arabic">
                {{ $order->user->fullName }}
            </div>
        @endif
        @if ($order->user->phone_number != '' && $order->user->phone_number)
            <div class="mt-0-5 fw-bold ff-primary">
                {{ $order->user->phone_number }}
            </div>
        @endif
        @if ($order->user->email != '' && $order->user->email)
            <div class="mt-0-5 fw-bold ff-primary">
                {{ $order->user->email }}
            </div>
        @endif
        @if ($order->address != '' && $order->address)
            <div class="mt-0-5 fw-bold ff-arabic">
                {{ $order->address['line_one'] . ', ' . $order->address['city'] }}
            </div>
        @endif

    </div>
    {{-- Buery Info --}}

    <div class="line"></div>


    {{-- Sellers --}}
    @foreach ($order->sellers as $seller)
        <div class="sellers primary-color mt-1"
            @if (!$loop->last) style="page-break-after: always;" @endif>
            <div class="fw-400 fs-20 ff-primary">
                Seller information
            </div>
            <div class="mt-1-5 fw-bold">
                <div class="fl w-5 fw-400 ff-arabic">
                    Name
                </div>
                <div>
                    {{ $seller['user']['name'] }}
                </div>
            </div>
            <div class="mt-0-5 fw-bold ff-primary">
                <div class="fl w-5 fw-400">
                    Number
                </div>
                <div>
                    {{ $seller['user']['phone_number'] }}
                </div>
            </div>
            <div class="mt-0-5 fw-bold ff-primary">
                <div class="fl w-5 fw-400">
                    E-mail
                </div>
                <div>
                    {{ $seller['user']['email'] }}
                </div>

            </div>

            <div class="mt-0-5 fw-bold">
                <div class="fl w-5 fw-400 ff-primary">
                    Address
                </div>
                <div class="ff-arabic">
                    {{ $seller['address'] }}
                </div>
            </div>

            <div class="seller-product">
                <div class="mt-2 fw-bold fs-20 primary-color"> Products</div>
                <table class="mt-1-5 fs-20" style="border-left: none !important;border-right: none !important;">
                    <tr>
                        <th style="width: 37%;border-left: none !important;">
                            <p class="ff-primary">Product Name</p>
                        </th>
                        <th style="width: 10%;" class="ff-primary">
                            <p class="ff-primary">Quantity</p>
                        </th>
                        <th style="width: 10%;" class="ff-primary">
                            <p class="ff-primary">color</p>
                        </th>

                        <th style="width: 10%;" class="ff-primary">
                            <p class="ff-primary">Size</p>
                        </th>
                        <th style="width:25%;" class="ff-primary">
                            <p class="ff-primary">Purchase Price</p>
                        </th>
                        <th style="width: 13%;" class="ff-primary">
                            <p class="ff-primary">Price</p>
                        </th>
                        <th style="width: 13%;border-right: none !important;" class="ff-primary">
                            <p class="ff-primary">Total</p>
                        </th>
                    </tr>
                    @php
                        $totalSeller = 0;
                    @endphp
                    {{-- Products loop --}}
                    @foreach ($seller['orderItems'] as $item)
                        <tr>
                            <td class="ff-arabic">
                                {{ $item->stock->product->name }}
                            </td>
                            <td>
                                {{ $item->product_quantity }}
                            </td>
                            <td>
                                <div
                                    style="border-radius: 50% ;width:1rem;height: 1rem;background-color: #{{ $item->stock->variant['color'] }};color:#{{ $item->stock->variant['color'] }}">
                                    123456
                                </div>
                            </td>
                            <td>
                                @if (array_key_exists('size', $item->stock->variant))
                                    {{ $item->stock->variant['size'] }}
                                @else
                                    standard
                                @endif
                            </td>
                            <td>
                                {{ $item->stock->purchase_price }} s.p
                            </td>
                            <td>
                                {{ $item->stock->price }} s.p
                            </td>
                            <td>
                                {{ $item->price }} s.p
                            </td>
                            @php
                                $totalSeller += $item->price;
                            @endphp
                        </tr>
                    @endforeach

                    <tr>
                        <td class="ff-primary fw-400">Total</td>
                        <td colspan="5"></td>
                        <td>{{ $totalSeller }} s.p</td>
                    </tr>
                    {{-- End products loop --}}
                </table>
            </div>

            {{-- <div class="mt-2 w-full">
                <div class="fw-400 fs-20 w-half fl">Total
                    {{ $order->total_price + $order->shipping_cost + $order->tax }} s.p</div>
                <div style="font-size: 40px;" class="ff-secondry">Stamp/Signature</div>
            </div>
            <div class="line"></div> --}}
        </div>
    @endforeach
    <div class="seller-invoice mt-4 primary-color">
        <div class="fw-400 w-13 fs-20 ff-primary">
            Total Invoice
        </div>
        <div>
            <div class="w-13 fw-400 fl mt-2">
                Payment Way
            </div>
            <div style="padding: 0px;margin-left: 130px;" class="w-9">
                <img class="w-5" style="padding-top: -22px;" width="50px" height="4rem"
                    src="data:image/jpeg;base64,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"
                    alt="">
            </div>
        </div>
        @if ($order->coupon)
            <div>
                <div class="fl w-13 fw-400">
                    Price
                </div>
                <div>
                    {{ $order->total_price + $order->discount }} s.p
                </div>
            </div>
            <div class="mt-1">
                <div class="fl w-13 fw-400">
                    Coupon
                </div>
                <div>
                    {{ $order->coupon->name }}
                </div>
            </div>
            <div class="mt-1">
                <div class="fl w-13 fw-400">
                    Price after Coupon
                </div>
                <div>
                    {{ $order->total_price }} s.p
                </div>
            </div>
        @else
            <div>
                <div class="fl w-13 fw-400">
                    Price
                </div>
                <div>
                    {{ $order->total_price }} s.p
                </div>
            </div>
        @endif
        <div class="mt-1">
            <div class="fl w-13 fw-400">
                Delivery
            </div>
            <div>
                @if ($order->shipping_cost == 0)
                    free
                @else
                    {{ $order->shipping_cost }} s.p
                @endif
            </div>
        </div>
        <div class="mt-1">
            <div class="fl w-13 fw-400">
                Tax
            </div>
            <div>{{ $order->tax }} s.p</div>
        </div>
        <div class="mt-1">
            <div class="fl w-13 fw-400">
                Tip
            </div>
            <div>0.0 s.p</div>
        </div>
    </div>

    <div class="line"></div>

    <div class="mt-2 w-full">
        <div class="fw-400 fs-20 w-half fl">Total {{ $order->total_price + $order->shipping_cost + $order->tax }} s.p
        </div>
        <div style="font-size: 40px;" class="ff-secondry">Stamp/Signature</div>
    </div>

    {{-- Sellers --}}

</body>

</html>
