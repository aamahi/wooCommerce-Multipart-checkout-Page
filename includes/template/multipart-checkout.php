<form id="regForm">
    <!-- One "tab" for each step in the form: -->
    <div class="tab">
        <?php
            do_action( 'woocommerce_multipart_checkout_billing' );
        ?>
    </div>
    <div class="tab">Shipping Address:
        <?php
            do_action( 'woocommerce_multipart_checkout_shipping' );
        ?>

    </div>
    <div class="tab">Order and Payment :
        <?php
        do_action( 'woocommerce_multipart_checkout_order_review' );
        ?>
    </div>

    <div style="overflow:auto;">
        <div style="float:right;">
            <button type="button" id="prevBtn" onclick="nextPrev(-1)">Previous</button>
            <button type="button" id="nextBtn" onclick="nextPrev(1)">Next</button>
        </div>
    </div>
    <!-- Circles which indicates the steps of the form: -->
    <div style="text-align:center;margin-top:40px;">
        <span class="step"></span>
        <span class="step"></span>
        <span class="step"></span>
    </div>
</form>