<html>

<head>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios@1.1.2/dist/axios.min.js"></script>

</head>

<body>
    <div>
        <label for="title">Title:<input name="title" type="text"></label><br/>
        <label for="content">Content:<br/>
            <textarea name="content" ></textarea></label>
        <button id="createBtn">Create</button>
    </div>
    <div>
        <label for="search">Search (by key):<input name="search" type="text"></label>
        <button id="searchBtn">Search</button>
    </div>
    <table id="todolist" border="1">
        <thead>
            <tr>
                <th>Delete</th>
                <th>Title</th>
                <th>Content</th>
                <th>Create At</th>
                <th>Update At</th>
                <th>Update</th>
            </tr>
        </thead>
        <tbody id="todolistBody">

        </tbody>
    </table>
    <script>
        $(document).ready(function(){
            todoComponent.index();

            const createBtn = document.getElementById('createBtn');
            createBtn.onclick = ()=>{
                const title = document.querySelector('input[name="title"]').value;
                const content = document.querySelector('textarea[name="content"]').value;
                let data = {
                    "title": title,
                    "content": content
                };
                todoComponent.create(data);
            }


            const searchBtn = document.getElementById('searchBtn');
            searchBtn.onclick = ()=>{
                const keyId = document.querySelector('input[name="search"]').value;
                todoComponent.show(keyId);
            }
        });

        let todoComponent = {
            index: function() {
                axios.get('http://localhost:8080/todo')
                    .then((response) => {
                        const resdata = response.data;
                        if (resdata.msg == "success") {
                            makeTable(resdata.data);
                        }

                    })
                    .catch((error) => console.log(error.response.data.messages.error));
            },
            show: function(key) {
                axios.get('http://localhost:8080/todo/' + key)
                    .then((response) => {
                        const resdata = response.data;
                        if (resdata.msg == "success") {
                            makeTable([resdata.data]);
                        }

                    })
                    .catch((error) => console.log(error.response.data.messages.error));
            },
            create: function(data) {
                axios.post('http://localhost:8080/todo', JSON.stringify(data))
                    .then((response) => {
                        if(response.data.msg == "create successfully"){
                            document.querySelector('input[name="title"]').value = "";
                            document.querySelector('textarea[name="content"]').value = "";
                            this.index();
                        }
                    })
                    .catch((error) => console.log(error.response.data.messages.error));
            },
            update: function(key,data) {
                axios.put('http://localhost:8080/todo/' + key,JSON.stringify(data))
                    .then((response) => {
                        const resdata = response.data;
                        if (resdata.msg == "Update successfully") {
                            this.index();
                        }
                    })
                    .catch((error) => console.log(error.response.data.messages.error));
            },
            delete: function(key) {
                axios.delete('http://localhost:8080/todo/' + key)
                    .then((response) => {
                        const resdata = response.data;
                        if (resdata.msg == "Delete successfully") {
                            this.index();
                        }
                    })
                    .catch((error) => console.log(error.response.data.messages.error));
            }
        }


        function makeTable(data){
            let todolistBodyInnerHTML = "";
            for (let todoItem of data ) {
                todolistBodyInnerHTML+=`
                    <tr>    
                        <td><button onclick="todoComponent.delete('${todoItem.t_key}')">Delete</button></td>                                
                        <td id='title_${todoItem.t_key}'>${todoItem.t_title}</td>
                        <td id='content_${todoItem.t_key}'>${todoItem.t_content}</td>
                        <td>${todoItem.created_at}</td>
                        <td>${todoItem.updated_at}</td>
                        <td><button id='updateBtn_${todoItem.t_key}' onclick="onEditingMode('${todoItem.t_key}')">Update</button></td>                                
                    <tr>
                `;
            }
            const todolistBody = document.getElementById('todolistBody');
            todolistBody.innerHTML = todolistBodyInnerHTML;
        }


        function onEditingMode(key){
            const title = document.getElementById(`title_${key}`).innerText;
            const content = document.getElementById(`content_${key}`).innerText;

            document.getElementById(`title_${key}`).innerHTML = `<input type="text" id="titleInput_${key}" value='${title}'>`;
            document.getElementById(`content_${key}`).innerHTML = `<input type="text" id="contentInput_${key}" value='${content}'>`;
            document.getElementById(`updateBtn_${key}`).innerText = 'Save';
            document.getElementById(`updateBtn_${key}`).onclick=()=>{
                onUpdateMode(key);
            }
        }

        function onUpdateMode(key){
            const title = document.getElementById(`titleInput_${key}`).value;
            const content = document.getElementById(`contentInput_${key}`).value;
            todoComponent.update(key,{
                title:title,
                content:content
            });
        }
    </script>
</body>

</html>