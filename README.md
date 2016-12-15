# php7-pdf-creator
Uses phantomjs to create PDFs. Written using a couple of features available in PHP7.

## Example usage
### Create many documents using an array
```
$maker = new Maker\DocumentMakerEntity;

$pages[] = ['Doc1 Page1', 'Doc1 Page2'];
$pages[] = ['Doc2'];

$pages[] = [
    (new ElementEntity)->setContent('This element has style')
        ->addStyle('background-color', 'blue')
        ->addStyle('color', '#FFF')
];

$maker->buildFromArray(DocumentFormatsEnum::A4, $pages);
```

### Create a footer
The footer is created as an HTML element object.
The pageNum and pageCount are replaced with the actual value. The same rules apply for $maker->setHeader(..).
```
$footer = (new Element\ElementEntity)
    ->setContent('Page pageNum of pageCount')
    ->addStyle('text-align', 'center');

$maker->setFooter(
    $footer,
    new Dimension(30, 'px')
);
```

### Create the writer object
This creates the object that will write PDFs to disk.
```
$writer = (new Writer\PdfWriter)->setDirectory('/tmp');
```

### Specify the writer
By telling the DocumentMakerEntity what writer to use, it will use this to write PDFs to disk and return the PDF file locations.

If you were to want to do something besides writing the documents to disk, you could implement `Writer\WriterInterface` and provide that as an alternate using the ->writeUsing() method.
```
$writtenFiles = $maker->writeUsing($writer);
```
### Output one of the PDFs
Just to show that it worked, let's get the first PDF and attach it inline.
```
$firstFile = $writtenFiles->first();

if (!$firstFile) {
  throw new Exception("No files were written!");
}
```

Most of the objects in this repository extend `StringableTrait` and implement `StringableInterface` and therefore doing `echo $obj` will automatically convert it to a string.

For example:
```
echo (new InlinePdfPresenter)->readPdfFile($firstFile);
```

If anyone is interested in this, please let me know and we can look at developing it further.
