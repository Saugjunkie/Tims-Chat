<script type="text/javascript" src="{@$__wcf->getPath('chat')}js/be.bastelstu.WCF.Chat.js{if $chatVersion|isset}?version={$chatVersion|urlencode}{/if}"></script>
<script type="text/javascript" src="{@$__wcf->getPath('chat')}js/jCounter.jQuery.js"></script>
{if CHAT_SOCKET_IO_PATH}<script type="text/javascript" src="{CHAT_SOCKET_IO_PATH}/socket.io/socket.io.js"></script>{/if}
<script type="text/javascript" src="{@$__wcf->getPath('chat')}js/be.bastelstu.WCF.Chat.Log.js{if $chatVersion|isset}?version={$chatVersion|urlencode}{/if}"></script>
{event name='javascript'}