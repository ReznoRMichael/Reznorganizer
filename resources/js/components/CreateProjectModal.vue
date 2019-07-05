<template>
    <modal name="create-project-modal" classes="p-10 bg-card rounded-lg" height="auto">

        <h1 class="mb-16 text-2xl text-center">Create something awesome.</h1>

        <form @submit.prevent="submit">
            <div class="flex">
    
                <div class="flex-1 mr-4">
                    <div class="mb-4">
                        <label for="title" class="text-sm block mb-2">Title</label>
                        <input type="text" name="title" id="title"
                            class="border p-2 text-sm w-full rounded bg-transparent"
                            :class="form.errors.title ? 'border-accent' : 'border-rtgray'"
                            v-model="form.title">
                            <span class="text-xs text-accent" v-if="form.errors.title" v-text="form.errors.title[0]"></span>
                    </div>
                    <div class="mb-4">
                        <label for="description" class="text-sm block mb-2">Description</label>
                        <textarea name="description" id="description"
                            class="border p-2 text-sm w-full rounded bg-transparent"
                            :class="form.errors.description ? 'border-accent' : 'border-rtgray'"
                            rows="7" v-model="form.description"></textarea>
                            <span class="text-xs text-accent" v-if="form.errors.description" v-text="form.errors.description[0]"></span>
                    </div>
                </div>
    
                <div class="flex-1 ml-4">
                    <div class="mb-4">
                        <label class="text-sm block mb-2">Need some tasks?</label>
                        <input type="text" class="border border-rtgray mb-2 p-2 text-sm w-full rounded bg-transparent"
                            placeholder="Add some tasks..." v-for="(task, idx) in form.tasks" :key="idx" v-model="task.body">
                    </div>
    
                    <button type="button" class="inline-flex items-center text-xs hover:text-accent" @click="addTask">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18" class="mr-2">
                            <g fill="none" fill-rule="evenodd" opacity=".2">
                                <path stroke="#000" stroke-opacity=".012" stroke-width="0" d="M-3-3h24v24H-3z"></path>
                                <path fill="#000" d="M9 0a9 9 0 0 0-9 9c0 4.97 4.02 9 9 9A9 9 0 0 0 9 0zm0 16c-3.87 0-7-3.13-7-7s3.13-7 7-7 7 3.13 7 7-3.13 7-7 7zm1-11H8v3H5v2h3v3h2v-3h3V8h-3V5z"></path>
                            </g>
                        </svg>
    
                        <span>Add New Task Field</span>
                    </button>
                </div>
            </div>
    
            <footer class="flex justify-end">
                <button type="button" class="button btn-gray mr-4" @click="$modal.hide('create-project-modal')">Cancel</button>
                <button type="submit" class="button">Create Entry</button>
            </footer>
        </form>

    </modal>
</template>

<script>

    import ReznorganizerForm from './ReznorganizerForm';

export default {
    data() {
        return {
            tcounter: 0,
            form: new ReznorganizerForm({
                title: '',
                description: '',
                tasks: [
                    { body: '' }
                ]
            })
        };
    },
    methods: {
        addTask() {
            if(this.form.tasks[this.tcounter].body != '')
            {
                this.form.tasks.push( { body: '' } );
                this.tcounter++;
            }
        },
        async submit() {

            // delete empty tasks from the array (if there are any)
            if( this.form.tasks.length )
            {
                for(var i=0; i < this.form.tasks.length; i++)
                {
                    if(this.form.tasks[ i ].body == '')
                    {
                        this.form.tasks.splice(i, 1);
                        // if a task was deleted, i also has to be decremented!
                        i--;
                    }
                }
            }

            // always add an empty task, in case the above loop deleted everything
            if( !this.form.tasks.length )
            {
                this.form.tasks.push( { body: '' } );
            }
            
            // prevent posting the tasks to SQL (form.originalData) if the last task input is empty
            if(!this.form.tasks[0].body) delete this.form.originalData.tasks;

            this.form.submit('/reznorganizer/public/projects')
                     .then(response => location = response.data.projectpath);
        }
    }
}
</script>
