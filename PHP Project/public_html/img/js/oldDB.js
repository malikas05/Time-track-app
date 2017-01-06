var user_data = {
    // TODO update PHP - add today and currentTaskExists
    today: 'mon', // will be updated latter
    currentTaskExists: true, // will eb adjusted via JS latter
    current: { // set to undefined if there is no current task
        id: 10, //unique Task ID from DB
        name: "Task 55",
        tagsApplied: [1,3,5],  //tag IDs as per tags object bellow //undefined means no tags applied
        projectApplied: 1, //project ID as per projects object bellow //undefined means no project applied
        categoryApplied: 1, //set to undefined if no category applied otherwise contains index of array wher category description is located as per projects object bellow
        startTime: 1480313027, //epoch time
        endTime: undefined // undefined means the task is still running
    },
    thisweek: {
        sun: undefined,
        mon: [
            {
                id: 9,
                name: "How to do3455345345 stuff",
                tagsApplied: [3,2,1],
                projectApplied: 1,
                categoryApplied: 1,
                startTime: 1480312027,
                endTime: 1480313342
            },{
                id: 8,
                name: "reading",
                tagsApplied: undefined,
                projectApplied: 2,
                categoryApplied: undefined,
                startTime: 1480300000,
                endTime: 1480313342
            },{
                id: 7,
                name: "junk",
                tagsApplied: [3,5],
                projectApplied: 3,
                categoryApplied: undefined,
                startTime: 1480310000,
                endTime: 1480313342
            }
        ],
        tue: [
            {
                id: 6,
                name: "browsing internet",
                tagsApplied: [4],
                projectApplied: 1,
                categoryApplied: 1,
                startTime: 1480313027,
                endTime: 1480313342
            },{
                id: 5,
                name: "watching youtube",
                tagsApplied: [1,2,3,4,5],
                projectApplied: 5,
                categoryApplied: undefined,
                startTime: 1480311027,
                endTime: 1480313342
            },{
                id: 4,
                name: "procrastinating",
                tagsApplied: undefined,
                projectApplied: 4,
                categoryApplied: undefined,
                startTime: 1480311527,
                endTime: 1480313342
            }
        ],
        wed: undefined, // undefined means there are no entries for that day or that the day is in the future
        thu: undefined,
        fri: undefined,
        sat: undefined
    },
    projects: [ // All projects available to user
        {
            id: 1, //unique project ID from DB
            name: "Project 1 - Project Description",
            color: "#324344",
            categories: ["Category 1 - Category Description", "Category 2 - Category Description","Category 3- Category Description"], // undefined means there is no categories applied to this project
            categoryIDs: [2324, 23, 33], // undefined means there is no categories applied to this project
        },{
            id: 2,
            name: "Project 2 - Project Description",
            color: "#543645",
            categories: undefined,
            categoryIDs: undefined
        },{
            id: 3,
            name: "Project 3 - Project Description",
            color: "#ffffff",
            categories: undefined,
            categoryIDs: undefined
        },{
            id: 4,
            name: "Project 4 - Project Description",
            color: "#34f3ff",
            categories: undefined,
            categoryIDs: undefined
        },{
            id: 5,
            name: "Project 5 - Project Description",
            color: "#aabbcc",
            categories: undefined,
            categoryIDs: undefined
        },
    ],
    tags: [ // All tags available to user
        {
            id: 1, //unique tag ID from DB
            name: "$",
            color: "#666666"
        },{
            id: 2,
            name: "Out of scope",
            color: undefined // means there is no unique color applied
        },{
            id: 3,
            name: "Personal",
            color: "#993333"
        },{
            id: 4,
            name: "Other stuf",
            color: "#333399"
        },{
            id: 5,
            name: "Sort this out",
            color: "#7423ff"
        }
    ]
};
