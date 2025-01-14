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

    a {
        color: inherit;
    }

    li {
        list-style: none;
    }

    table {
        margin-top: 30px;
        border: 1px solid #000000;
    }

    th, td {
        border: 1px solid #555555;
    }

    th:nth-child(1) {
        width: 300px;
    }

    th:nth-child(2) {
        width: 150px;
    }

    th:nth-child(3) {
        width: 100px;
    }

    th:nth-child(4) {
        width: 200px;
    }

    th:nth-child(5) {
        width: 150px;
    }
    
    th:nth-child(6) {
        width: 100px;
    }

    .header-upper {
        background-color: #4F2469;
        display: flex;
        margin: auto 0;
        line-height: 40px;
        padding: 10px 20px;
        column-gap: 10px;
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
        margin: 1px 0 0 0;
        padding-left: 20px;
        line-height: 29px;
        text-align: left;
    }

    .title {
        margin-top: 20px;
        margin-bottom: 20px;
    }

    .wrapper_index {
        width: 720px;
        display: block;
        margin: 0 auto;
    }

    .wrapper_main {
        width: 90%;
        max-width: 1080px;
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
</style>