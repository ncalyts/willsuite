<template>
    <div class="flex flex-col justify-center items-center">
        <form class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4" @submit.prevent="onSubmit">
            <span v-text="errors"></span>
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="title">Title</label>
                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" 
                    id="title" 
                    type="text" 
                    name="title" 
                    v-model="title" 
                    required 
                    @keydown="errors = ''"
                >
            </div>
            <div class="mb-6">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="content">Content</label>
                <textarea class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    id="content" 
                    type="textarea" 
                    rows="4"
                    cols="50"
                    name="content" 
                    v-model="content"
                >
                </textarea>
            </div>
            <input v-model="id" type="hidden">
            <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline"
                v-bind:class="{'isLoading' : isLoading}">
                {{ buttonText }}
            </button>
        </form>
    </div>
</template>

<script>
import axios from 'axios';
import { API_BASE_URL } from '@/config';

export default {
    data() {
        return {
            title: '',
            content: '',
            id: '',
            buttonText: 'Add Note',
            errors: '',
            isLoading: false
        }
    },
    emits: ["completed"],
    props: ['noteId', 'noteTitle', 'noteContent', 'editButtonText'],
    watch: {
        noteId(newId) {
            this.id = newId;
        },
        noteTitle(newTitle) {
            this.title = newTitle;
        },
        noteContent(newContent) {
            this.content = newContent;
        },
        editButtonText(newContent) {
            this.buttonText = newContent;
        }
    },
    methods: {
        onSubmit() {
            this.isLoading = true
            if (this.id == '') {
                this.postNewNote()
            } else {
                this.updateNote()
            }
        },
        async postNewNote() {
            await axios.post(API_BASE_URL + '/notes', this.$data)
            .then( response => {
                this.title = '',
                this.content = '',
                this.id = '', 
                this.isLoading = false,
                this.$emit('completed', response.data.data)
            })
            .catch(error => {
                this.errors = error.response.data.errors
                this.isLoading = false
            })
        },
        async updateNote() {
            await axios.put(API_BASE_URL + '/notes/' + this.id, this.$data)
            .then (response => {
                this.title = '',
                this.content = '',
                this.buttonText = 'Add Note',
                this.id = '',
                this.isLoading = false, 
                this.$emit('updated', response.data.data)
            })
        }
    }
}
</script>

<style>

</style>