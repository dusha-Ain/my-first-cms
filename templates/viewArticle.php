<?php include "templates/include/header.php" ?>

      <h1><?php echo htmlspecialchars( $results['article']->title )?></h1>
      
      <div class="article-meta">
          <span class="pubDate">Publication date: <?php echo date('j F Y', $results['article']->publicationDate)?></span>
          
          <?php if ( isset($results['article']->categoryId) && $results['article']->categoryId ) { ?>
            <span class="category">
                | Category: 
                <a href=".?action=archive&amp;categoryId=<?php echo $results['article']->categoryId?>">
                    <?php 
                    $category = Category::getById($results['article']->categoryId);
                    echo htmlspecialchars($category->name )
                    ?>
                </a>
            </span>
            
            <?php if ( isset($results['article']->subcategoryId) && $results['article']->subcategoryId ) { ?>
                <span class="subcategory">
                    | Subcategory: 
                    <a href=".?action=archiveBySubcategory&amp;subcategoryId=<?php echo $results['article']->subcategoryId?>">
                        <?php 
                        $subcategory = Subcategory::getById($results['article']->subcategoryId);
                        echo $subcategory ? htmlspecialchars($subcategory->name) : 'Unknown';
                        ?>
                    </a>
                </span>
            <?php } ?>
          <?php } 
          else { ?>
          <br>
            <span class="category">| Без категории</span>
          <?php } ?>
          
          <?php 
          $authors = Article::getArticleAuthors($results['article']->id);
          if (!empty($authors)) { 
              $authorNames = array();
              foreach ($authors as $author) {
                  $authorNames[] = $author->username;
              }
          ?>
          <br>
            <span class="authors">| Authors: <?php echo htmlspecialchars(implode(', ', $authorNames)); ?></span>
          <?php } ?>
      </div>
      
      <div class="summary"><?php echo htmlspecialchars( $results['article']->summary )?></div>
      <div class="content"><?php echo $results['article']->content?></div>

      <p><a href="./">Return to Homepage</a></p>

<?php include "templates/include/footer.php" ?>