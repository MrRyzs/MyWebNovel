<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Novel</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="../css/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>
<body>
    <div class="container">
        <h2>Create Novel</h2>
        <form method="post" action="create-process.php" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="novel_title" class="form-label">Novel Title</label>
                <input type="text" class="form-control" id="novel_title" name="novel_title" required>
            </div>
            <div class="mb-3">
                <label for="novel_genre" class="form-label">Novel Genre</label>
                <select class="form-select" id="novel_genre" name="novel_genre" required>
                    <option selected disabled>Select Genre</option>
                    <option value="Fantasy">Fantasy</option>
                    <option value="Romance">Romance</option>
                    <option value="Sci-Fi">Sci-Fi</option>
                    <option value="Fan-Fiction">Fan-Fiction</option>
                </select>
            </div>
            <div class="autocomplete mb-3">
                <label for="input">Tags</label>
                <input type="text" id="input" name="selectedTags">
                <ul id="autocomplete-list" class="autocomplete-list"></ul>
                <div id="selected-tags" class="selected-tags"></div>
            </div>
            <div class="mb-3">
                <label for="novel_description" class="form-label">Novel Description</label>
                <textarea class="form-control" id="novel_description" name="novel_description" rows="3" required></textarea>
            </div>
            <div class="mb-3">
                <label for="novel_img" class="form-label">Novel Image</label>
                <input type="file" class="form-control" id="novel_img" name="novel_img" accept="image/*" required>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>

    <script>
        const input = document.getElementById('input');
        const list = document.getElementById('autocomplete-list');
        const selectedTagsContainer = document.getElementById('selected-tags');
        let allTags = []; // Ganti nama variabel menjadi allTags
        let selectedTags = [];

        const tags = [
            { title: 'Aggressive Characters' },
            { title: 'Alchemy' },
            { title: 'Aliens' },
            { title: 'Alternate Universe' },
            { title: 'Anti-Magic' },
            { title: 'Artificial Intelligence' },
            { title: 'Body Tempering' },
            { title: 'Cultivation' },
            { title: 'Demons' },
            { title: 'Dragons' },
            { title: 'Dungeon' },
            { title: 'Evolution' },
            { title: 'Fantasy World' },
            { title: 'Game Elements' },
            { title: 'Guilds' },
            { title: 'Hard-Working Protagonist' },
            { title: 'Harem-seeking Protagonist' },
            { title: 'Immortality' },
            { title: 'Magic' },
            { title: 'Male Protagonist' },
            { title: 'Medieval' },
            { title: 'Monsters' },
            { title: 'Necromancer' },
            { title: 'Pets' },
            { title: 'Politics' },
            { title: 'Polygamy' },
            { title: 'Possession' },
            { title: 'Power Struggle' },
            { title: 'Protagonist Strong from the Start' },
            { title: 'Reincarnation' },
            { title: 'Ruthless Protagonist' },
            { title: 'Scheming' },
            { title: 'Wars' },
            { title: 'Weak to Strong' },
            { title: 'World Travel' },
        ];

        allTags = tags; // Menetapkan nilai tags ke allTags

        input.addEventListener('input', function() {
            const query = input.value.toLowerCase();
            const filteredTags = allTags.filter(tag => tag.title.toLowerCase().includes(query)); // Ubah variabel tags menjadi allTags
            allTags = filteredTags; // Ubah variabel tags menjadi allTags
            renderList();
        });

        input.addEventListener('focus', function() {
            if (input.value.trim().length > 0) {
                renderList();
            }
        });

        document.addEventListener('click', function(event) {
            if (!event.target.closest('.autocomplete')) {
                list.innerHTML = '';
            }
        });

        input.addEventListener('keydown', function(event) {
            if (event.key === 'ArrowDown') {
                event.preventDefault();
                const activeIndex = allTags.findIndex(tag => tag.title === document.activeElement.textContent); // Ubah variabel tags menjadi allTags
                const nextIndex = activeIndex === allTags.length - 1 ? 0 : activeIndex + 1; // Ubah variabel tags menjadi allTags
                const nextOption = list.childNodes[nextIndex];
                if (nextOption) {
                    nextOption.focus();
                }
            } else if (event.key === 'ArrowUp') {
                event.preventDefault();
                const activeIndex = allTags.findIndex(tag => tag.title === document.activeElement.textContent); // Ubah variabel tags menjadi allTags
                const prevIndex = activeIndex === 0 ? allTags.length - 1 : activeIndex - 1; // Ubah variabel tags menjadi allTags
                const prevOption = list.childNodes[prevIndex];
                if (prevOption) {
                    prevOption.focus();
                }
            } else if (event.key === 'Enter') {
                event.preventDefault();
                input.value = document.activeElement.textContent;
                list.innerHTML = '';
                addTag(input.value);
                input.value = '';
            }
        });

        function renderList() {
            list.innerHTML = '';
            allTags.forEach(tag => { // Ubah variabel tags menjadi allTags
                if (!selectedTags.includes(tag.title)) {
                    const li = document.createElement('li');
                    li.textContent = tag.title;
                    li.addEventListener('click', function() {
                        input.value = tag.title;
                        list.innerHTML = '';
                        addTag(input.value);
                        input.value = '';
                    });
                    list.appendChild(li);
                }
            });
        }

        function addTag(tagName) {
            if (selectedTags.length < 10 && !selectedTags.includes(tagName)) {
                const tag = document.createElement('div');
                tag.classList.add('tag');
                tag.textContent = tagName;
                const closeButton = document.createElement('span');
                closeButton.textContent = '×';
                closeButton.classList.add('close-button');
                closeButton.addEventListener('click', function() {
                    removeTag(tagName);
                });
                tag.appendChild(closeButton);
                selectedTagsContainer.appendChild(tag);
                selectedTags.push(tagName);
            }
        }

        function removeTag(tagName) {
            const tagIndex = selectedTags.indexOf(tagName);
            if (tagIndex !== -1) {
                selectedTags.splice(tagIndex, 1);
                selectedTagsContainer.removeChild(selectedTagsContainer.childNodes[tagIndex]);
            }
        }
    </script>
</body>
</html>
