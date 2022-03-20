# MOCKEND

Mockend is the fastest way to mock APIs. You can generate custom API responses with Mockend and begin working on your application before the backend is ready.Mockend is the fastest way to mock APIs. You can generate custom API responses with Mockend and begin working on your application before the backend is ready.

## Table of Contents

- [Getting started](#getting-started)
    * [How it works](#how-it-works)
    * [Installation](#installation)
- [Configuration](#configuration)
    * [Model](#model)
    * [Field](#field)
    * [Types](#types)
- [Built-in types](#built-in-types)
    * [id](#id)
    * [random](#random)
    * [belongsTo](#belongsto)
    * [hasMany](#hasmany)
    * [hasOne](#hasone)
- [Meta](#meta)
- [Faker Type](#faker-type)
    * [Available faker methods](#available-faker-methods)



## Getting started

### How it works

Mockend lets you describe your data with a config file (`.mockend.json`), and It'll automatically generate a fake CRUD API.

You can enter your values or use mockend flexible and straightforward generators to create meaningful fake data, so the possibilities are nearly endless.

### Installation

Mockend is a laravel application, So please check the official laravel installation guide for server requirements before you start. [Official Documentation](https://laravel.com/docs/9.x/installation)

1- Clone the repository

    git clone git@github.com:bvtterfly/mockend.git

2- Switch to the repo folder

    cd mockend

3- Install all the dependencies using composer

    composer install

4- Copy the example env file and make the required configuration changes in the .env file

    cp .env.example .env

5- Generate a new application key

    php artisan key:generate

6- Start the local development server

    php artisan serve

You can now access the server at `http://localhost:8000`

## Configuration

Mockend is configured using a `.mockend.json` file.

A config file is like this:

```
{
  "ModelName": {
    "fieldName": {
      "<type>": "<parameters>",
    }
  }
}
```

### Model

Model names are **singular** and **start with a capital letter**.

> Mockend generates routes by default with the "sluggish", plural name of the model.

If we define a User model:
```
{
    "User": {
        ...
    }
}
```

Mockend generates these routes:

| Method | Path        |
|--------|-------------|
| GET    | /users      |
| POST   | /users      |
| GET    | /users/{id} |
| PUT    | /users/{id} |
| DELETE | /users/{id} |

> `POST`, `PUT` and `DELETE` requests are mocked and changes aren't saved.


> Mockend supports `_delay` query params for Arbitrary Delaying response in Milliseconds.

### Field

Field names can be any valid JSON field name.

### Types

Field's type defines like this:

```
"fieldName": {
    "<type>": "<parameters>"
}
```

If a type has a default value or doesn't get a parameter, it looks like this:

```
"fieldName": {
    "<type>": {}
}
```

In this case you can define a field type like this:

```
"fieldName": "<type>"
```

## Built-in types

### id

Acts like The auto-increment in SQL, so it can automatically generate and provide a unique integer value to every record.

```
{
    "Post": {
        "id": "id"
    }
}
---
GET /posts:
---
[
    {
        "id": 1
    },
    {
        "id": 2
    },
    {
        "id": 3
    }
]
```

### random

Returns random element from the given array.

```
{
    "Post": {
        "status": ["published", "draft"]
    }
}
---
GET /posts:
---
[
    {
        "status": "published"
    },
    {
        "status": "draft"
    },
    {
        "status": "draft"
    }
]
```

### belongsTo

Can describe `belongsTo` relation to another model.

```
{
    "User": {
        "id": "id"
    },
    "Post": {
        "id": "id",
        "auther": {
            "belongsTo": "User"
        }
    }
}
---
GET /posts:
---
[
    {
        "id": 1,
        "author": {
            "id": 1
        }
    },
    {
        "id": 2,
        "author": {
            "id": 2
        }
    },
    {
        "id": 3,
        "author": {
            "id": 3
        }
    }
]
```

### hasMany

Can describe `hasMany` relation to another model.

```
{
    "User": {
        "id": "id",
        "posts": {
            "hasMany": "Post"
        }
    },
    "Post": {
        "id": "id"
    }
}
---
GET /users:
---
[
    {
        "id": 1,
        "posts": [
            {
                "id": 1
            },
            {
                "id": 2
            },
            {
                "id": 3
            }
        ]
    }
    ...
]
```


### hasOne

Can describe `hasOne` relation to another model.

```
{
    "User": {
        "id": "id",
        "email": {
            "hasOne": "Email"
        }
    },
    "Email": {
        "id": "id"
    }
}
---
GET /users:
---
[
    {
        "id": 1,
        "email": {
            "id": 1
        }
    }
    ...
]
```

## Meta

We sometimes needed to generate random objects (`Email` in above example) but did not need to generate CRUD APIs for them, So we needed a way to override default behavior when generating fake CRUD API.

We do this by using the `_meta` field in the Model.

`_meta` field has 3 properties:
- `crud`: determine crud is enabled or not(Default: `true`)
- `limit`: the number of items you would like displayed in show method(Default: `10`)
- `route`: use this instead of default "sluggish", plural name of the model for generated routes(Default: `null`)

So in above example we can disable crud:

```
"Email": {
    "_meta": {
        "crud" : false,
    },
    ...
}

```

## Faker Type

Mockend relies on the FakerPHP/Faker library for generating random data conveniently, and you can also use faker random generators just like built-in types.

[Learn more about faker methods](https://fakerphp.github.io/formatters/).

### Available faker methods

```
title
titleMale
titleFemale
suffix
name
firstName
firstNameMale
firstNameFemale
lastName
word
words
sentence
email
boolean
emoji
regexify
uuid
cityPrefix
secondaryAddress
state
stateAbbr
citySuffix
streetSuffix
buildingNumber
city
streetName
streetAddress
postcode
address
country
latitude
longitude
phoneNumber
phoneNumberWithExtension
tollFreePhoneNumber
e164PhoneNumber
catchPhrase
bs
company
companySuffix
jobTitle
randomDigit
randomDigitNot
randomDigitNotNull
randomNumber
randomFloat
numberBetween
randomLetter
randomElements
randomElement
numberBetween
shuffle
numerify
lexify
bothify
asciify
sentences
paragraph
paragraphs
text
unixTime
dateTime
dateTimeAD
iso8601
date
time
dateTimeBetween
dateTimeInInterval
dateTimeThisCentury
dateTimeThisDecade
dateTimeThisYear
dateTimeThisMonth
amPm
dayOfMonth
dayOfWeek
month
monthName
year
century
timezone
safeEmail
freeEmail
companyEmail
freeEmailDomain
safeEmailDomain
userName
password
domainName
domainWord
tld
url
slug
ipv4
localIpv4
ipv6
macAddress
userAgent
chrome
firefox
safari
opera
internetExplorer
creditCardType
creditCardNumber
creditCardExpirationDate
creditCardExpirationDateString
creditCardDetails
iban
swiftBicNumber
hexColor
safeHexColor
rgbColorAsArray
rgbColor
rgbCssColor
rgbaCssColor
safeColorName
colorName
hslColor
hslColorAsArray
mimeType
fileExtension
imageUrl
image
ean13
ean8
isbn10
isbn13
md5
sha1
sha256
locale
countryCode
countryISOAlpha3
languageCode
currencyCode
biasedNumberBetween
randomHtml
semver
```

For using faker methods with parameters, you can pass them via a string or array:

```
{
    "User": {
        "id": "uuid",
        "first_name": "firstName",
        "last_name": "lastName",
        "email": "email",
        "birth_day": {
            "date": "Y-m-d"
        },
        "bio": {
            "text": [100]
        },
        "latitude": {
            "latitude": [-45,45]
        },
        "longitude": {
            "longitude": [-90,90]
        }    
    }
}
```

