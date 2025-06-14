const apiErrorMessageHandler = (error) => {
  const response = error.response;

  const errorValues = Object.values(response._data?.errors ?? {});

  const errorMap = errorValues.flatMap((error) => error);

  if (errorMap.length === 0) {
    return (
      response?._data?.message || "Nastala chyba pri komunikácii so serverom."
    );
  }

  return errorMap.join("\n");
};

export default apiErrorMessageHandler;
