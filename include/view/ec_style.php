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
        top: 90px;
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
        background-color: #9ba88d;
    }

    .list_bg1 {
        background-color: #ffffff;
    }

    .product_list th, td {
        border: 1px solid #555555;
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

    .header-upper {
        background-color: #4F2469;
        display: flex;
        margin: auto 0;
        line-height: 40px;
        padding: 10px 20px;
        column-gap: 20px;
    }

    .header-upper li {
        font-size: 18px;
        list-style: none;
        margin: auto 0;
        text-decoration: none;
    }

    .header-upper li:nth-of-type(1){
        margin-right: auto;
    }

    .header-upper a {
        text-decoration: none;
    }

    .header-lower {
        background-color: #711D1D;
        margin: 0;
        padding-left: 20px;
        line-height: 29px;
        text-align: left;
    }

    .title {
        margin-top: 20px;
        margin-bottom: 20px;
    }

    .wrapper_main {
        width: 90%;
        max-width: 800px;
        display: block;
        margin: 0 auto;
    }

    .align-left {
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
        margin-top: 10px;
        margin-bottom: 24px;
        width: 180px;
        height: 30px;
        border: 0;
        border-radius: 5px;
        background-color: #9845cc;
        box-shadow: 2px 2px #261133;
        color: #e7e7eb;
        font-size: 16px;
        font-weight: bold;
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

    .catalog_element button {
        background-color: #9845cc;
        box-shadow: 2px 2px #261133;
        color: #e7e7eb;
        margin-bottom: 8px;
    }

    .soldout_text {
        color: #c53d43;
        font-weight: bold;
    }
</style>