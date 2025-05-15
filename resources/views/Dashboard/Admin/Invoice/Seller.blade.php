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


        .fl {
            float: left !important;
        }

        .ff-primary {
            font-family: 'istok_web' !important;

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
            font-family: 'istok_web'
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
                <div class="fl invoice-world" style="width: 20rem;">
                    <h1 style="font-size: 1.5rem;">Invoice </h1>
                </div>
                <div class="invoice-number fl" style="width: 14rem;">
                    Invoice no.
                    {{ $invoiceNumber }}
                </div>
                <div class="invoice-date" style="width: 100px;">
                    {{ $order->created_at->format('Y-m-d') }}
                </div>
            </div>
        </div>
        {{-- Logo --}}
    </htmlpageheader>

    <div class="sellers primary-color pt-2">

        <div class="fw-400 fs-20 ff-primary">
            Seller information
        </div>
        <div class="mt-1-5 fw-bold">
            <div class="fl w-5 fw-400" style="font-weight: sans-serif !important;">
                Name
            </div>
            <div>
                {{ $seller['user']['name'] ?? '---' }}
            </div>
        </div>
        <div class="mt-0-5 fw-bold">
            <div class="fl w-5 fw-400">
                Number
            </div>
            <div>
                {{ $seller['user']['phone_number'] ?? '---' }}
            </div>
        </div>
        <div class="mt-0-5 fw-bold">
            <div class="fl w-5 fw-400">
                E-mail
            </div>
            <div>
                {{ $seller['user']['email'] ?? '---' }}
            </div>

        </div>

        <div class="mt-0-5 fw-bold">
            <div class="fl w-5 fw-400">
                Address
            </div>
            <div>
                {{ $seller['address'] ?? '---' }}
            </div>
        </div>
    </div>
    {{-- Sellers --}}
    <div class="sellers primary-color pt-2">
        @php
            $total = 0;
        @endphp
        <div class="seller-product">
            <div class="mt-2 fw-bold fs-20 primary-color"> Products</div>
            <table class="mt-1-5 fs-20 ff-primary" style="border-left: none !important;border-right: none !important;">
                <tr>
                    <th style="width: 37%;border-left: none !important;font-weight: sans-serif !important;">
                        Product Name
                    </th>
                    <th style="width: 10%;">
                        Quantity
                    </th>
                    <th style="width: 10%;">
                        Color
                    </th>

                    <th style="width: 10%;">
                        Size
                    </th>
                    <th style="width:25%;">
                        Purchase Price
                    </th>
                    <th style="width: 13%;border-right: none !important;">
                        Total
                    </th>
                </tr>
                @foreach ($orderItems as $item)
                    {{-- Products loop --}}
                    <tr>
                        <td>
                            {{ $item['stock']['product']['name'] }}
                        </td>
                        <td>
                            {{ $item['product_quantity'] }}
                        </td>
                        <td>
                            <div
                                style="border-radius: 50% ;width:1rem;height: 1rem;background-color: #{{ $item['stock']['variant']['color'] }};color:#{{ $item['stock']['variant']['color'] }}">
                                123456
                            </div>
                        </td>
                        <td>
                            @if (array_key_exists('size', $item['stock']['variant']))
                                {{ $item['stock']['variant']['size'] }}
                            @else
                                standard
                            @endif
                        </td>
                        <td>
                            {{ $item['stock']['purchase_price'] }}
                        </td>
                        <td>
                            {{ $recordTotal = $item['stock']['purchase_price'] * $item['product_quantity'] }}
                            @php
                                $total += $recordTotal;
                            @endphp
                        </td>
                    </tr>
                @endforeach

                {{-- End products loop --}}
            </table>
        </div>
        <div class="mt-2 w-full">
            <div class="fw-400 fs-20 w-half fl">Total {{ $total }} s.p</div>
            <div style="font-size: 40px;" class="ff-secondry">Stamp/Signature</div>
        </div>
    </div>

    {{-- Sellers --}}

</body>

</html>
