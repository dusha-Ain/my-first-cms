$(function(){
    console.log('AJAX загрузка содержимого статей инициализирована');
    init_get();
    init_post();
});

function getLoaderIdentity(contentId) {
    var $li = $('li.' + contentId);
    return $li.find('.loader-identity');
}

function showLoaderIdentity(contentId) {
    var $loader = getLoaderIdentity(contentId);
    if ($loader.length) {
        $loader.show();
    }
}

function hideLoaderIdentity(contentId) {
    var $loader = getLoaderIdentity(contentId);
    if ($loader.length) {
        $loader.hide();
    }
}

function init_get() 
{
    $('a.ajaxArticleBodyByGet').on('click', function(e){
        e.preventDefault();
        var contentId = $(this).attr('data-contentId');
        var $link = $(this);
        var $li = $('li.' + contentId);
        
        // Проверяем, не было ли уже добавлено содержимое
        var $existingContent = $li.find('.article-content');
        if ($existingContent.length > 0) {
            // Если содержимое уже есть, не добавляем повторно
            return false;
        }
        
        console.log('GET запрос: ID статьи = ', contentId); 
        
        showLoaderIdentity(contentId);
        
        $.ajax({
            type: "GET",
            url: 'ajax/showContentsHandler.php?articleId=' + contentId, 
            dataType: 'json'
        })
        .done(function(response){
            hideLoaderIdentity(contentId);
            
            if (response.success) {
                console.log('GET ответ получен успешно');
                // Проверяем еще раз перед добавлением
                if ($li.find('.article-content').length === 0) {
                    var $contentDiv = $('<div class="article-content"></div>');
                    $contentDiv.html(response.content);
                    $li.append($contentDiv);
                }
            } else {
                console.error('GET ошибка:', response.error);
                alert('Ошибка: ' + response.error);
            }
        })
        .fail(function(xhr, status, error){
            hideLoaderIdentity(contentId);
            
            console.log('ajaxError xhr:', xhr);
            console.log('ajaxError status:', status);
            console.log('ajaxError error:', error);
            
            var errorInfo = 'Ошибка выполнения запроса: '
                + '\n[' + xhr.status + ' ' + status + ']'
                + ' ' + error;
            
            console.log('GET ошибка соединения:', errorInfo);
            alert('Ошибка загрузки данных (GET): ' + error);
        });
        
        return false;
    });  
}

function init_post() 
{
    $('a.ajaxArticleBodyByPost').on('click', function(e){
        e.preventDefault();
        var contentId = $(this).attr('data-contentId');
        var $link = $(this);
        var $li = $('li.' + contentId);
        
        // Проверяем, не было ли уже добавлено содержимое
        var $existingContent = $li.find('.article-content');
        if ($existingContent.length > 0) {
            // Если содержимое уже есть, не добавляем повторно
            return false;
        }
        
        console.log('POST запрос: ID статьи = ', contentId);
        
        showLoaderIdentity(contentId);
        
        $.ajax({
            type: "POST",
            url: 'ajax/showContentsHandler.php', 
            dataType: 'json',
            data: {
                articleId: contentId
            }
        })
        .done(function(response){
            hideLoaderIdentity(contentId);
            
            if (response.success) {
                console.log('POST ответ получен успешно', response);
                // Проверяем еще раз перед добавлением
                if ($li.find('.article-content').length === 0) {
                    var $contentDiv = $('<div class="article-content"></div>');
                    $contentDiv.html(response.content);
                    $li.append($contentDiv);
                }
            } else {
                console.error('POST ошибка:', response.error);
                alert('Ошибка: ' + response.error);
            }
        })
        .fail(function(xhr, status, error){
            hideLoaderIdentity(contentId);
            
            console.log('POST ajaxError xhr:', xhr);
            console.log('POST ajaxError status:', status);
            console.log('POST ajaxError error:', error);
            
            var errorInfo = 'Ошибка выполнения запроса: '
                + '\n[' + xhr.status + ' ' + status + ']'
                + ' ' + error + ' \n '
                + xhr.responseText;
            
            console.log('POST ошибка соединения:', errorInfo);
            alert('Ошибка загрузки данных (POST): ' + error);
        });
        
        return false;
    });  
}