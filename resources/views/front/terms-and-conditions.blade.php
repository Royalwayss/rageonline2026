@extends('layouts.frontLayout.front-layout')
@section('content')

<main class="inner-page">
    <section class="policy-page">
        <div class="container">

            <div class="detail-breadcrumb" data-aos="fade-up">
                <a href="{{ url('/') }}">Home</a>
                <span>/</span>
                <span>Terms &amp; Conditions</span>
            </div>

            <div class="policy-content-box" data-aos="fade-up" data-aos-delay="100">
                <h1>Terms &amp; Conditions</h1>

                <p><b>Online Purchases</b></p>
                <div>
                    <p>All prices, unless indicated otherwise are in Indian Rupees.</p>
                    <p>In a credit card transaction, you must use your own credit card. Rage will not be liable for any credit card fraud.</p>
                    <p>In case of non-delivery, unsatisfactory or delayed performance of services or damages or delays will be dealt by the management and all efforts towards peaceful settlement will be entertained.</p>
                    <p>Orders will be delivered within 10 days of receipt of payment. Complaints, dis-satisfaction will be sensitively tended to. If you happen to find defect/s in products, we will be happy to exchange it after due verification of the nature/cause/circumstances of the damage/injury and if the evidences support the defective nature of the garment.</p>
                    <p>In the event that a non-delivery occurs on account of a mistake by you (i.e. wrong name or address) any extra cost towards re-delivery shall be claimed from the user placing the order.</p>
                    <p>Delivery of orders would be done address specific not person specific.</p>
                    <p>Shipment/delivery time of order processing starts from the day of receipt of the payment/COD(Cash on Delivery)confirmed against the order placed with Rage. Rage shall not be liable for any delay/non-delivery of purchased goods by the flood, fire, wars, acts of God or any Force Majeure that is beyond the control of Rage.</p>
                    <p>Complaints filed in cases of fraudulence in payment/non-return of payment will be under jurisdiction of Ludhiana Courts.</p>
                    <p>Presently, the service(s) of Rage Shopping are being offered free of cost. However, Rage reserves the right to charge a fee for any or such facilities.</p>
                    <p>Rage reserves the right to confirm and authenticate the information and other details provided by the User at any point of time. If upon confirmation such User details are found not to be true (wholly or partly) and are suspected to be used in mal-intentions, Rage has the right in its sole discretion to reject the order and debar the User from further interactions.</p>
                    <p>Partial delivery of product needs to be reported within 10 days of receipt of the product.</p>
                    <p>The color/look of the garment appearing as on the website may slightly differ from the actual product because of shading and light variations.</p>
                </div>

                <p><b>Cancellation/Refund Policy</b></p>
                <div>
                    <p>All orders cancelled, with the value below or equal to Rs. 2000/- will be either refunded to the user's account of transaction or in the form of Rage Discount Voucher or equivalent within 7 working days via email. The respective terms &amp; conditions will stand valid with the voucher at any point of time.</p>
                    <p>All orders cancelled, with the value above Rs. 2000/- will be refunded to the user's account of transaction.</p>
                    <p>Rage reserves the right to cancel any order placed using Credit Card which holds International Billing Address or appears dubious in probity.</p>
                </div>

                <p><b>Termination/Suspension</b></p>
                <div>
                    <p>The User agrees that Rage may under certain circumstances and without prior notice, immediately terminate the User's user ID and access to the Website/Services. Causes for termination may include, but shall not be limited to requests by enforcement or government agencies, etc.</p>
                </div>

                <p><b>Communication with Users</b></p>
                <div>
                    <p>Rage reserves the right to communicate with Users regarding this site and user's use of this site or any product or service purchased by user on this site.</p>
                    <p>Contest's, competition's, offer's running at www.rageonline.co.in come with no obligation of compliance or liability or responsibility to compulsorily reward the winner/participant. Rewards/prizes are only meant to appreciate the participant's effort and interest and in no way does the participant stand liable/entitled for the reward. The contest may/may not come with Terms &amp; Conditions, and the rules written hereby should be considered as absolute governance of Rage over any eligibility/liability/answerability.</p>
                    <p>Rage Knit and only Rage reserves the right to choose winners on a purely random basis.</p>
                </div>

                {{-- NOTE: this heading duplicates the one above it word-for-word,
                     but its content is actually about court jurisdiction, not
                     user communication - looks like a copy-paste heading bug
                     in the source. Left exactly as provided since this is
                     legal text; flagged separately in chat rather than
                     silently retitled. --}}
                <p><b>Communication with Users</b></p>
                <div>
                    <p>All disputes arising in relation hereto shall be subject to the exclusive jurisdiction of the courts of Ludhiana.</p>
                </div>

            </div>

        </div>
    </section>
</main>
@stop