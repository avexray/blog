{extends file='layout.tpl'}

{block name=body}
    <h1>HTTP Error {$code}</h1>
    <div>{$message}</div>
{/block}