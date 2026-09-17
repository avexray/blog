{extends file='layout.tpl'}

{block name=body}
    <div class="post">
        <h1>{$post['title']|escape}</h1>
        <div>
            {foreach $post['categories'] as $category}
                <a class="post-category" href="/categories?id={$category['id']}">{$category['title']|escape}</a>
            {/foreach}
        </div>
        <div class="post__views">Views: {$post['view_count']}</div>

        <div class="post__content">{$post['content']|escape}</div>
        <div class="post__date">{$post['created_at']|date_format: '%A, %B %e, %Y'}</div>
    </div>

    {if !empty($recommendedPosts)}
        <h3>Recommended posts</h3>
        <div class="post-recommendations">
            {foreach $recommendedPosts as $post}
                <div class="post-summary">
                    <a class="post-summary__title" href="/posts?id={$post['id']}">{$post['title']|escape}</a>
                    <div class="post-summary__views">Views: {$post['view_count']}</div>
                    <p class="post-summary__content">{$post['description']|escape}</p>
                    <div class="post-summary__date">{$post['created_at']|date_format: '%A, %B %e, %Y'}</div>
                </div>
            {/foreach}
        </div>
    {/if}
{/block}