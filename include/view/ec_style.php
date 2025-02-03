<style>
    body {
        font-family: Noto Sans JP;
        font-size: 16px;
        color: #203744;
        margin: 0;
    }

    header {
        position: fixed;
        top: 0px;
        left: 0px;
        width: 100%;
        color: #e7e7eb;
        /*font-weight: bold;*/
    }

    main {
        position: absolute;
        top: 120px;
        left: 0px;
        width: 100%;
        z-index: -1;
        text-align: center;
    }

    h1 {
        margin: 0;
        font-size: 28px;
    }

    h2 {
        margin: 0;
    }

    h3 {
        margin: 0;
        font-size: 18px;
    }

    a {
        color: inherit;
    }

    li {
        list-style: none;
    }

    .product_list {
        margin: 30px auto;
        border: 1px solid #000000;
    }

    .list_bg0 {
        background-color: #f6bfbc;
    }

    .list_bg1 {
        background-color: #ffffff;
    }

    .list_bg2 {
        background-color: #9e9478;
    }

    .product_list th, td {
        border: 1px solid #9ba88d;
    }

    .product_list th:nth-child(1) {
        width: 140px;
    }

    .product_list th:nth-child(2) {
        width: 180px;
    }

    .product_list th:nth-child(3) {
        width: 70px;
    }

    .product_list th:nth-child(4) {
        width: 180px;
    }

    .product_list th:nth-child(5) {
        width: 120px;
    }
    
    .product_list th:nth-child(6) {
        width: 90px;
    }

    .product_list img {
        max-width: 120px;
        margin: 10px;
        object-fit: contain;
    }

    .header_upper {
        background-color: #4F2469;
        display: flex;
        margin: auto 0;
        line-height: 40px;
        padding: 10px 20px;
        column-gap: 20px;
    }

    .header_upper a {
        text-decoration: none;
    }

    .header_upper li {
        font-size: 18px;
        list-style: none;
        margin: auto 0;
        text-decoration: none;
    }

    .header_upper li:nth-of-type(1){
        margin-right: auto;
    }

    .header_lower {
        background-color: #711D1D;
        margin: 0;
        padding-left: 20px;
        line-height: 29px;
        text-align: left;
    }

    .title {
        margin-bottom: 20px;
    }

    .wrapper_index {
        width: 720px;
        display: block;
        margin: 0 auto;
    }

    .wrapper_main {
        width: 90%;
        max-width: 800px;
        display: block;
        margin: 0 auto;
    }

    .wrapper_middle {
        width: 90%;
        max-width: 660px;
        display: block;
        margin: 0 auto;
    }

    .align_left {
        text-align: left;
    }

    .caution_msg {
        display: block;
        margin: 5px auto;
        line-height: 32px;
        background-color: #f5e56b;
    }

    .err_msg {
        display: block;
        line-height: 32px;
        margin: 0 auto;
        background-color: #f2a0a1;
        font-weight: bold;
    }

    .suc_msg {
        display: block;
        line-height: 32px;
        margin: 0 auto;
        background-color: #c1e4e9;
        font-weight: bold;
    }

    button {
        background-color: #d3cbc6;
        border: 0;
        border-radius: 3px;
        box-shadow: 1px 1px #281a14;
        font-size: 14px;
    }

    .file_btn {
        line-height: 26px;
    }

    .file_btn::file-selector-button {
        background-color: #d3cbc6;
        border: 0;
        border-radius: 3px;
        box-shadow: 1px 1px #281a14;
        font-size: 14px;
    }

    .form_btn {
        /*
        margin-top: 10px;
        margin-bottom: 24px;
        */
        margin: 10px 10px 16px 10px;
        width: 180px;
        height: 30px;
        border: 0;
        border-radius: 5px;
        background-color: #9845cc;
        box-shadow: 2px 2px #261133;
        color: #e7e7eb;
        font-size: 16px;
        font-weight: bold;
        vertical-align: middle;
    }

    .input_value {
        width: 60px;
    }

    .catalog_container {
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        margin-top: 20px;
        margin-bottom: 30px;
    }

    .catalog_element {
        width: 254px;
        text-align: center;
        margin: 2px;
        padding: 2px;
        border: solid 2px #adadad;
    }
    
    .catalog_element img {
        width: 240px;
        height: 240px;
        object-fit: contain;
    }

    .catalog_element p {
        margin: 4px;
    }

    .catalog_element button,.history_list button {
        background-color: #9845cc;
        box-shadow: 2px 2px #261133;
        color: #e7e7eb;
        margin-bottom: 8px;
    }

    .red_text {
        color: #c53d43;
        font-weight: bold;
    }

    .purple_text {
        color: #4F2469;
        font-weight: bold;
    }

    .small_text {
        font-size: 14px;
        margin: 0;
    }

    .cart_list,.thankyou_list {
        margin: 30px auto;
        border: 1px solid #000000;
    }

    .history_list {
        margin: 20px auto;
        border: 1px solid #000000;
    }

    .borderless {
        border: none !important;
    }

    .cart_list td,.thankyou_list td,.history_list td {
        border: 1px solid #9ba88d;
    }

    .cart_list img,.thankyou_list img,.history_list img {
        max-width: 120px;
        margin: 10px;
        object-fit: contain;
    }

    .cart_list td:nth-child(1) {
        width: 140px;
    }

    .cart_list td:nth-child(2) {
        width: 216px;
    }

    .cart_list td:nth-child(3) {
        width: 120px;
    }

    .cart_list td:nth-child(4) {
        width: 160px;
    }

    .cart_list td:nth-child(5) {
        width: 130px;
    }

    .thankyou_list td:nth-child(1), .history_list td:nth-child(1) {
        width: 140px;
    }

    .thankyou_list td:nth-child(2), .history_list td:nth-child(2) {
        width: 232px;
    }

    .thankyou_list td:nth-child(3), .history_list td:nth-child(3) {
        width: 130px;
    }

    .thankyou_list td:nth-child(4), .history_list td:nth-child(4) {
        width: 130px;
    }

    .subtotal {
        margin: 0 0 20px 0;
        text-align: right;
        font-size: 22px;
    }

    .history_list_left {
        text-align: left;
        font-size: 22px;
    }
    
    .history_list_right {
        text-align: right;
        font-size: 22px;
    }

</style>