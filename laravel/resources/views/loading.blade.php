<style>
    .spinner {
        --size: 30px;
        --first-block-clr: #005bba;
        --second-block-clr: #fed500;
        --clr: #111;
        width: 100px;
        height: 100px;
        position: relative;
        animation: spin 2s linear infinite;
    }

    .spinner::after,
    .spinner::before {
        box-sizing: border-box;
        position: absolute;
        content: "";
        width: var(--size);
        height: var(--size);
        top: 50%;
        left: 50%;
        background: var(--first-block-clr);
        border-radius: 50%;
        transform: translate(-50%, -50%);
        animation: orbit 2s linear infinite, up 2s infinite;
    }

    .spinner::after {
        background: var(--second-block-clr);
        animation: orbit 2s linear infinite, down 2s infinite;
    }

    @keyframes orbit {
        0% {
            transform: rotate(0deg);
        }

        100% {
            transform: rotate(360deg);
        }
    }

    @keyframes down {

        0%,
        100% {
            transform: none;
        }

        25% {
            transform: translateX(100%);
        }

        50% {
            transform: translateX(100%) translateY(100%);
            filter: blur(10px);
        }

        75% {
            transform: translateY(100%);
        }
    }

    @keyframes up {

        0%,
        100% {
            transform: none;
        }

        25% {
            transform: translateX(-100%);
        }

        50% {
            transform: translateX(-100%) translateY(-100%);
            filter: blur(10px);
        }

        75% {
            transform: translateY(-100%);
        }
    }

    @keyframes spin {
        0% {
            transform: rotate(0deg);
        }

        100% {
            transform: rotate(360deg);
        }
    }

    .container-loading {
        position: absolute;
        top: 50%;
        left: 50%;
        z-index: 1900;
    }


</style>

<div class="container-loading">
    <div class="spinner"></div>
</div>
<div class="background"
    style="position: absolute;width: 100vw; height: 100rem; background-color: black; opacity: 0.5; z-index: 1700; overflow: auto;">
</div>
