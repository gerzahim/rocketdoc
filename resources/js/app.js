require('./bootstrap');


// Markdown Editor JS
import Editor from '@toast-ui/editor'
//import 'codemirror/lib/codemirror.css';
import '@toast-ui/editor/dist/toastui-editor.css';


// Load Initial Value for Editor
const editor = new Editor({
    el: document.querySelector('#editor'),
    height: '400px',
    initialEditType: 'markdown',
    initialValue: document.querySelector('#document').value,
    //placeholder: 'Write something cool!',
})



// catch editor Content and save on Input , before to submit
document.querySelector('#editReleaseForm').addEventListener('submit', e => {
    e.preventDefault();
    let editorContent = editor.getMarkdown();
    document.querySelector('#document').value = editor.getMarkdown();
    e.target.submit();
});

