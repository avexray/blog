{extends file='layout.tpl'}

{block name=body}
    <h1>Homepage</h1>
    {foreach $categories as $category}
        {if isset($category['posts'])}
            <div class="category">
                <div class="category__title">{$category['title']|escape}</div>

                {foreach $category['posts'] as $post}
                    <div class="post-summary">
                        <a class="post-summary__title" href="/posts?id={$post['id']}">{$post['title']|escape}</a>
                        <div class="post-summary__views">Views: {$post['view_count']}</div>
                        <p class="post-summary__content">{$post['description']|escape}</p>
                        <div  class="post-summary__date">{$post['created_at']|date_format: '%A, %B %e, %Y'}</div>
                    </div>
                {/foreach}

                <a class="category__link" href="/categories?id={$category['id']}">See All Posts</a>
            </div>
        {/if}
    {/foreach}
{/block}