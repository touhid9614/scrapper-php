import tensorflow as tf
import numpy as numpy
from numpy import array
import csv
import os

cron_name = 'crestviewchrysler'
data_dir  = os.path.join( os.path.dirname(os.path.dirname(os.path.dirname(os.path.realpath(__file__)))), 'adwords3', 'data', 'trainingdata', cron_name)

train_file = os.path.join(data_dir, 'training.csv')
test_file     = os.path.join(data_dir, 'test.csv')

train_data = []
train_labels = []

with open(train_file) as csv_file:
    csv_reader = csv.reader(csv_file, delimiter=',')
    line_count = 0
    for row in csv_reader:
        train_row = row[2:16]
        for x in range(0, len(train_row)):
            if train_row[x] == '' or train_row[x] == '-1':
                train_row[x] = 0
            else:
                train_row[x] = int(float(train_row[x]))
        train_label = int(float(row[16]))
        train_data.append(array(train_row))
        train_labels.append(train_label)
        line_count += 1
    print(f'Processed {line_count} lines of training data.')

test_data = []
test_labels = []

with open(test_file) as csv_file:
    csv_reader = csv.reader(csv_file, delimiter=',')
    line_count = 0
    for row in csv_reader:
        test_row = row[2:16]
        for x in range(0, len(test_row)):
            if test_row[x] == '' or test_row[x] == '-1':
                test_row[x] = 0
        test_label = row[16]
        test_data.append(array(test_row))
        test_labels.append(test_label)
        line_count += 1
    print(f'Processed {line_count} lines of test data.')

train_data = array(train_data)
train_labels = array(train_labels)
test_data = array(test_data)
test_labels = array(test_labels)

# Create the model

keras = tf.keras
imdb  = tf.keras.datasets.imdb

#(train_data, train_labels), (test_data, test_labels) = imdb.load_data(num_words=10000)

vocab_size = 500000

model = keras.Sequential()
model.add(keras.layers.Embedding(vocab_size, 16))
model.add(keras.layers.GlobalAveragePooling1D())
model.add(keras.layers.Dense(16, activation=tf.nn.relu))
model.add(keras.layers.Dense(1, activation=tf.nn.sigmoid))

model.summary()

# Set the loss function
model.compile(optimizer=tf.train.AdamOptimizer(),
              loss='binary_crossentropy',
              metrics=['accuracy'])

# Create a validation set
x_val = train_data[:100]
partial_x_train = train_data[100:]

y_val = train_labels[:100]
partial_y_train = train_labels[100:]

# Train the model
history = model.fit(partial_x_train,
                    partial_y_train,
                    epochs=20,
                    batch_size=16,
                    validation_data=(x_val, y_val),
                    verbose=1)

# Test the model
results = model.evaluate(test_data, test_labels)

print(results)

# Run For Data
for x in range(10):
    classes = model.predict(array([partial_x_train[x]]))

    print(classes)
    print("Prediction is: {}, Result is: {}".format(classes[0][0], partial_y_train[x]))
