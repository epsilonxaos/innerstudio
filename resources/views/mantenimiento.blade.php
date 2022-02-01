<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Inner Studio</title>
    <style>
        @import url('https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700,800&display=swap');
        body {
            font-family: 'Poppins', sans-serif;
            background-color: rgba(116,106,104,1);
            background-image: radial-gradient(circle, rgba(116,106,104,0.9009978991596639) 0%, rgba(116,106,104,1) 100%), url("{{asset('images/logininner.jpg')}}");
            background-repeat: no-repeat;
            background-position: center;
            background-size: cover;
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            align-items: center;
            color: #fff;
            height: 100vh;
            width: 100%;
            overflow: hidden;
        }
        .text-center {
            text-align: center;
        }
        svg {
            display: block;
            margin: auto;
        }
        img {
            display: inline-block;
        }
        h3 {
            font-weight: 400;
        }
    </style>
</head>
    <body>
        <div class="text-center">
            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="122" height="122" viewBox="0 0 122 122">
                <defs> <path id="gear" d="M72,52.4v-8.8l-5.4-0.9c-0.4-1.5-1-2.9-1.7-4.1l3.2-4.4l-6.2-6.3L57.4,31c-1.3-0.7-2.7-1.3-4.1-1.7L52.4,24h-8.8l-0.9,5.4  c-1.5,0.4-2.8,1-4.1,1.7L34.2,28l-6.3,6.2l3.2,4.4c-0.7,1.3-1.3,2.7-1.7,4.2L24,43.6v8.8l5.4,0.9c0.4,1.5,1,2.8,1.7,4.1l-3.2,4.5  l6.2,6.2l4.5-3.2c1.3,0.7,2.7,1.3,4.2,1.7l0.9,5.3h8.8l0.9-5.4c1.4-0.4,2.8-1,4.1-1.7l4.5,3.2l6.2-6.2l-3.2-4.5  c0.7-1.3,1.3-2.6,1.7-4.1L72,52.4z M48,57.2c-5.1,0-9.2-4.1-9.2-9.2c0-5.1,4.2-9.2,9.2-9.2s9.2,4.1,9.2,9.2S53.1,57.2,48,57.2z"/> </defs>
                <g transform="scale(0.77)">
                    <use xlink:href="#gear" fill="#FBB790">
                        <animateTransform
                            attributeType="XML"
                            attributeName="transform"
                            type="rotate"
                            from="0 48 48"
                            to="360 48 48"
                            dur="12s"
                            repeatCount="indefinite"
                        />
                    </use>
                </g>
                <g transform="scale(0.6) translate(83 13)">
                    <use xlink:href="#gear" fill="#FBB790">
                        <animateTransform
                            attributeType="XML"
                            attributeName="transform"
                            type="rotate"
                            from="360 48 48"
                            to="0 48 48"
                            dur="12s"
                            repeatCount="indefinite"
                        />
                    </use>
                </g>
                <g transform="scale(0.435) translate(37 139)">
                    <use xlink:href="#gear" fill="#FBB790">
                        <animateTransform
                            attributeType="XML"
                            attributeName="transform"
                            type="rotate"
                            from="360 48 48"
                            to="0 48 48"
                            dur="12s"
                            repeatCount="indefinite"
                        />
                    </use>
                </g>
                <g transform="scale(0.935) translate(36 39)">
                    <use xlink:href="#gear" fill="#FBB790">
                        <animateTransform
                            attributeType="XML"
                            attributeName="transform"
                            type="rotate"
                            from="0 48 48"
                            to="360 48 48"
                            dur="12s"
                            repeatCount="indefinite"
                        />
                    </use>
                </g>
                </svg>
            <img src="{{asset('images/logo/logo-2.svg')}}" alt="Inner Studio">
            <h3>En mantenimiento</h3>
        </div>
    </body>
</html>