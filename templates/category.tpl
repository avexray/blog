{extends file='layout.tpl'}

{block name=body}
    <div>
        <div class="category-header">
            <h1>{$category['title']|escape}</h1>
            <div class="category-description">{$category['description']|escape}</div>
            Sort by:
            <a href="/categories?id={$category['id']}&order=view_count">Views</a>
            <a href="/categories?id={$category['id']}&order=created_at">Date</a>
        </div>

        {foreach $posts as $post}
            <div class="post-summary">
                <a class="post-summary__title" href="/posts?id={$post['id']}">{$post['title']|escape}</a>
                <div class="post-summary__views">Views: {$post['view_count']}</div>
                <p class="post-summary__content">{$post['description']|escape}</p>
                <div class="post-summary__date">{$post['created_at']|date_format: '%A, %B %e, %Y'}</div>
            </div>
        {/foreach}

        {if $pagesCount > 1}
            <div class="pagination">
                {for $i = 1; $i <= $pagesCount; $i++}
                    {if $i === $page}
                        <span>{$i}</span>
                    {else}
                        <a href="/categories?id={$category['id']}&order={$orderBy}&page={$i}">{$i}</a>
                    {/if}
                {/for}
            </div>
        {/if}
    </div>
{/block}