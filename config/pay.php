<?php

return [
    'alipay' => [
        'app_id'         => '2016101300679290',
        'ali_public_key' => 'MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEA4iINbDaOKtN3xwshGlSyvTe5Q8r0//rlIzInrQvEwYz2s+5e8lwjXY8vWamabjDJH59MfVR+j9Cy2UWqs7kcvzVSzRKVbdtj4MHTK1kmDkNX5H4gecDTXCZsUfFm7gbeA3xxFYIKkFuFlQ1aGIOBqaCaJuHoZqzG6ZnZiKXKgm1t8sHNKW1CZMjA3mPuc8bIrrk0VkG9QzlarXVI/1VCCuCDzqb6x3Jha5GTdmEZMda19R2CbMqPOkfvl0CoXWfEumbKmHV3VEpGiCkV4v7F7vF0Xrn4o5rQL3HIb0Mw23Fpn3/+LgYP8i587Ti8TUOhxJwmNVavvzVaVc7e5CyopQIDAQAB',
        'private_key'    => 'MIIEowIBAAKCAQEA3Mm2f56MAEnFi+X0/BNieikYCkgVy1xV4ach/vwKOfEryws3oD2vyM+OjtgkapoHxAC2JPG+ajD+8M5QQvWAj9Hf8RugqdsCn/pvDWE/+tiOm4njQBq8iiHU9v2tw1X+VopjJcvDuprc/n+KRT2k4tr5Nq7g0yuzfwgUMXct1Ikg4WJAdbNaTdqEgORnYKH0xkuq+4Ijz7x4UWKAxOgyHVQVgcTvziaVTbrmz9WnzZaO/gAyU7OzElz+pLZEkeuUk6g2ponam/I/4FSCHdPknVtnzhAU1RuymHZBTO8Znr8CWF7urr4XRycJaLc/EEEGrvDYBueJ4i4uv9a8sLM5IQIDAQABAoIBABJ35QYj0v4rLZUYNTfovzIMwfAKO5h5Ls3jVxqnJovWOp2PYKXMwyl/AyO7vMAWBlRE4veQKSdk1c5604fmVUyyd5MJhpTutvd+0U9DNUDcYIFuNU4lbmP3lILckW5ngRDoHocI1mSDk7zOGljUYTiArJwAYNoJK8iSem3w1CqU7gqK/FslOnPy8bcrHzFZ66iwXQzJTljOlwn5YQGa4C3+RS3FYtpcHQDEMKruCP3KQUdvRslqprDTb/oNZfF6FBOMBDhTsz6Y2mKwfTmNgrnNV6bRMshKYrqarDRbv60Hz/2qj9yiPorO4yDuPjJ/VtfhiKYru2Wr0B8pKX5x6UkCgYEA/VVLstA+x5vLZ5rNgRg/Sa1EDOuBBdpsVFPfclUBIDr72dgpq2G1n92zz9NE0lmMOTJ73cyWxpXNmv2s9X3Qa84JfyWddBNiQsFeXlhPNAT0qvXgQNJaFEPLECxU3GczC69XG6yXkF+x2y43b8X5UsYkFMN91QBkFUDybivCppMCgYEA3xy2IEXWMPKfzMJfc6m+/YnaDVZopBIJEq+BnBLimM03TX/U9QxiaytrPMKInluDI++Kw6Mof/vycg8z5d+F1smJzo54PDX+zfofVOVs9D8ca2UtC4MfP2TCyJGFaPvL/GG+P/JEo58CNlzOHeU/JB11ObQ32lykkFgSgeff3fsCgYAnzpFYhbR3tRlfLEoCcQbw0tMQnKjnfIztK0i/NHA62kncz0Ss82uQtUud6nqz+vI3wqEIFy/SAJQQOLBG2wA3EGcZnZWCOdGE39GuTX4UlHrFqmEUjnktGgH8hprHD0hMG786UAJ44zCVWkvHunoU8aGVyaoqICeZ11zAxwuNFQKBgQCgtqXaiXPIvnytmjX3swaIy4vun5ew1+0BMLtEGbZwKyLzCGn2On2KhTQyCE8xAupsMFjco+LAjlQOJTVVGLXoCjTiPW4OsTZiWRHIrZrWNb/a/H5+FG2l1Icawvg+r2I44o+QsIsQ8bE+R4uRrVjWQwH2FwNEoAdKkqaCPOzdkQKBgCHANcfVyOufhGR5YmtT5t9EffcZJltrfKiNKd9xNEBjRqgkodDeq26e8buxjHYnNlE2gZ0OsUt7wTylHJ545CZxN20yRSRbw6JeemcmnmKMwEqRb6avGiFQmIpso/SIoBkSRVirybwrnKpPYG0BB5xfk2GoSV1M+ZKVBNaMuAFM',
        'log'            => [
            'file' => storage_path('logs/alipay.log'),
        ],
    ],

    'wechat' => [
        'app_id'      => 'wx*****', //公众号 app_id
        'mch_id'      => '', // 商户号
        'key'         => '', // 设置的api秘钥
        'cert_client' => resource_path('wechat_pay/apiclient_cert.pem'),
        'cert_key'    => resource_path('wechat_pay/apiclient_key.pem'),
        'log'         => [
            'file' => storage_path('logs/wechat_pay.log'),
        ],
    ],
];