<x-layouts.user-default>
    <x-slot name="insertstyle">
        <style>
        .conformation-table table{
            width: 100%
        }
        .conformation-table table thead{
            background-color: rgb(225 207 198);
        }
        .conformation-table table tr{
            display: flex;
            flex: 1;
        }
        .conformation-table table td,th{
            width: 33%;
            border: none;
            padding: 10px 20px
        }
        .conformation-table table tbody tr{
            display: flex;
        }

.conformation-head{
    margin-top: 30px;
    margin-bottom: 20px;
    text-align: center;
}
.main-conformation-body h1{
    font-size: 1rem;
    font-weight: 600;
    margin-bottom: 10px;
    display: flex;
    gap: 20px;
}
.main-conformation-body h1 span{
    font-weight: 400;
}
.extra-bold{
    font-weight: 600;
}
.product-detail-main-wrapper{
    height: calc(100vh - 240px);
}
        </style>
    </x-slot>
    <x-slot name="content">
        <div class="product-detail-main-wrapper">
            <div class="main-conformation-secion container">
                <div class="conformation-head">
                    <h1>Thank You</h1>
                    <h3>@if($message) {{ $message }}@else Order placed successfully @endif</h3>
                </div>
                <div class="main-conformation-body">
                     @if($transactionId && $date)

                    <h1>Transaction ID: <span>{{ $transactionId }}</span></h1>
                    <h1>Payment Date # <span>{{ $date }}</span></h1>
                        @else
                    <p>Payment details not found.</p>
                        @endif
                </div>

                <div class="conformation-fotter">
                    <div class="off-section">
                        <h3>Get 20% off </h3>
                        <p>Thank you for making this purchase! come Back and use Code "Back4More" to recieve a 20%discount on your next purchase </p>
                    </div>

                </div>
            </div>

        </div>
    </x-slot>
    <x-slot name="insertjavascript">


    </x-slot>
</x-layouts.user-default>
