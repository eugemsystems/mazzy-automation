<?php

return [
    'description' => 'Pague com segurança via Netcash Pay Now',
    'title' => 'Netcash',

    'redirect' => [
        'click-if-not-redirected' => 'Clique aqui para continuar',
        'please-wait' => 'Aguarde enquanto o redirecionamos para o gateway de pagamento...',
        'redirect-message' => 'Se você não for redirecionado automaticamente, clique no botão abaixo.',
        'redirecting' => 'Redirecionando para Netcash...',
        'redirecting-to-payment' => 'Redirecionando para Netcash Pay Now',
        'secure-payment' => 'Gateway de pagamento seguro',
    ],

    'response' => [
        'cart-not-found' => 'Carrinho não encontrado. Por favor, tente novamente.',
        'invalid-transaction' => 'Transação inválida. Por favor, tente novamente.',
        'order-creation-failed' => 'Falha ao criar o pedido. Por favor, contate o suporte.',
        'payment-failed' => 'O pagamento falhou ou foi cancelado. Por favor, tente novamente.',
        'payment-success' => 'Pagamento concluído com sucesso!',
        'provide-credentials' => 'Configure a Chave de Serviço do Netcash Pay Now no painel de administração.',
    ],
];
