<?php

return [
    'description' => '通过 Netcash Pay Now 安全付款',
    'title' => 'Netcash',

    'redirect' => [
        'click-if-not-redirected' => '点击此处继续',
        'please-wait' => '请稍候，我们正在将您重定向到支付网关...',
        'redirect-message' => '如果您没有被自动重定向，请点击下面的按钮。',
        'redirecting' => '正在重定向到 Netcash...',
        'redirecting-to-payment' => '正在重定向到 Netcash Pay Now',
        'secure-payment' => '安全支付网关',
    ],

    'response' => [
        'cart-not-found' => '未找到购物车。请重试。',
        'invalid-transaction' => '无效交易。请重试。',
        'order-creation-failed' => '订单创建失败。请联系支持。',
        'payment-failed' => '支付失败或已取消。请重试。',
        'payment-success' => '支付成功完成！',
        'provide-credentials' => '请在管理面板中配置 Netcash Pay Now 服务密钥。',
    ],
];
